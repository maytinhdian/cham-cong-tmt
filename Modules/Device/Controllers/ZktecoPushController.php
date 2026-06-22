<?php

namespace Modules\Device\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Device\Services\AttendanceDeviceCommandService;
use Modules\Device\Services\ZktecoPushAttendanceLogParser;
use Modules\Device\Services\ZktecoPushImportService;
use Modules\Device\Services\ZktecoPushProtocolService;

class ZktecoPushController extends Controller
{
    public function __construct(
        private readonly ZktecoPushProtocolService $protocolService,
        private readonly ZktecoPushAttendanceLogParser $parser,
        private readonly ZktecoPushImportService $importService,
        private readonly AttendanceDeviceCommandService $commandService,
    ) {
    }

    /**
     * Reply to device initialization and lightweight data requests.
     */
    public function cdata(Request $request): Response
    {
        $serialNumber = $this->serialNumber($request);
        $this->importService->touchDevice($serialNumber);

        if ($request->query('options') === 'all') {
            return $this->plain($this->protocolService->optionsResponse($serialNumber));
        }

        return $this->plain('OK');
    }

    /**
     * Receive pushed ATTLOG records and persist them as raw attendance logs.
     */
    public function upload(Request $request): Response
    {
        $serialNumber = $this->serialNumber($request);
        $table = strtoupper((string) $request->query('table'));

        if ($table !== 'ATTLOG') {
            $this->importService->touchDevice($serialNumber);

            return $this->plain('OK');
        }

        $logs = $this->parser->parse($request->getContent());
        $count = $this->importService->import($serialNumber, $logs);

        return $this->plain('OK: ' . $count);
    }

    /**
     * Keep device heartbeat and command polling compatible with ZKTeco PUSH.
     */
    public function getRequest(Request $request): Response
    {
        $device = $this->importService->touchDevice($this->serialNumber($request));
        $command = $this->commandService->dispatchNext($device);

        return $this->plain($command ?? 'OK');
    }

    /**
     * Acknowledge command execution replies sent back by the device.
     */
    public function deviceCommand(Request $request): Response
    {
        $device = $this->importService->touchDevice($this->serialNumber($request));
        $this->commandService->recordReplies($device, $request->getContent());

        return $this->plain('OK');
    }

    /**
     * Maintain heartbeat compatibility while large uploads are in progress.
     */
    public function ping(Request $request): Response
    {
        $this->importService->touchDevice($this->serialNumber($request));

        return $this->plain('OK');
    }

    /**
     * Resolve the device serial number sent by the PUSH client.
     */
    private function serialNumber(Request $request): string
    {
        return trim((string) $request->query('SN')) ?: 'UNKNOWN';
    }

    /**
     * Return plain text exactly as expected by attendance devices.
     */
    private function plain(string $content): Response
    {
        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
