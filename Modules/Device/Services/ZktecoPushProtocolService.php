<?php

namespace Modules\Device\Services;

class ZktecoPushProtocolService
{
    /**
     * Build the initialization response that tells a device to push ATTLOG data.
     */
    public function optionsResponse(string $serialNumber): string
    {
        return implode("\n", [
            'GET OPTION FROM: ' . $serialNumber,
            'ATTLOGStamp=None',
            'OPERLOGStamp=None',
            'ATTPHOTOStamp=None',
            'ErrorDelay=30',
            'Delay=10',
            'TransTimes=00:00;14:05',
            'TransInterval=1',
            'TransFlag=TransData AttLog',
            'TimeZone=7',
            'Realtime=1',
            'Encrypt=None',
            'ServerVer=TMT Attendance',
            'PushProtVer=2.4.1',
        ]) . "\n";
    }
}
