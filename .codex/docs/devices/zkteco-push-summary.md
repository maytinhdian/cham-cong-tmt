# ZKTeco PUSH Protocol Summary

Source: `zkteco-sdk.pdf` - Attendance PUSH Communication Protocol, PUSH SDK, Software Version 2.4.1, Doc Version 3.9, July 2020.

Related comparison note: `zkteco-push-version-diff.md` summarizes the differences between the March 2020 Attendance PUSH PDF and the January 2024 Security PUSH PDF.

## Purpose

ZKTeco PUSH is an HTTP-based protocol where the attendance device acts as the client. The server does not open a socket connection to the device. Instead, the device calls server endpoints to initialize, push attendance data, poll for commands, and report command results.

This project should treat the ZKTeco device serial number (`SN`) as the stable physical-device key. In the current app, it maps naturally to `attendance_devices.code`.

## Core Flow

1. Device initializes with the server.
   - Device calls `GET /iclock/cdata?SN=...&options=all`.
   - Server returns plain-text options beginning with `GET OPTION FROM: <SN>`.
   - Important options include `ATTLOGStamp`, `ErrorDelay`, `Delay`, `TransTimes`, `TransInterval`, `TransFlag`, `TimeZone`, `Realtime`, `Encrypt`, and `PushProtVer`.
   - Some protocol versions describe a stricter registered/unregistered device handshake before options are returned. TMT currently follows the attendance PUSH subset by auto-creating unknown serial numbers and returning options immediately.

2. Device uploads attendance logs.
   - Device sends `POST /iclock/cdata?SN=...&table=ATTLOG&Stamp=...`.
   - Body contains one or many tab-separated attendance rows.
   - Server returns `OK: <count>` after saving records.

3. Device polls for server commands.
   - Device calls `GET /iclock/getrequest?SN=...`.
   - Server returns `OK` when no command is pending.
   - Server returns command rows like `C: <CmdID>: LOG` when it wants the device to perform work.

4. Device replies to commands.
   - Device sends `POST /iclock/devicecmd?SN=...`.
   - Body contains reply rows like `ID=<CmdID>&Return=0&CMD=LOG`.
   - Server returns `OK`.

5. Device heartbeat / compatibility calls.
   - Some devices call heartbeat-style endpoints such as `/iclock/ping`.
   - Server can respond with plain `OK` and update the device's last-seen time.

## Server Options That Matter First

For attendance-log integration, the server should return a small option set:

```text
GET OPTION FROM: <SN>
ATTLOGStamp=None
OPERLOGStamp=None
ATTPHOTOStamp=None
ErrorDelay=30
Delay=10
TransTimes=00:00
TransInterval=1
TransFlag=TransData AttLog
TimeZone=7
Realtime=1
Encrypt=None
ServerVer=2.4.1
PushProtVer=2.4.1
```

Recommended project defaults:

- `TimeZone=7` for Vietnam.
- `Realtime=1` so the device pushes new attendance records as they are generated.
- `TransFlag=TransData AttLog` for the initial attendance-log-only scope.
- `Encrypt=None` unless a later real-device test requires encrypted communication.

## Attendance Log Format

`ATTLOG` records are tab-separated and line-separated:

```text
<PIN>\t<Time>\t<Status>\t<Verify>\t<Workcode>\t<Reserved>\t<Reserved>
```

Example:

```text
1452    2015-07-30 15:16:28    0    1    0    0    0
```

Field notes:

- `PIN`: device user code. Map this through `attendance_device_user_maps.device_user_code`.
- `Time`: punch timestamp, format `YYYY-MM-DD HH:mm:ss`.
- `Status`: attendance state from device. For basic use, treat it as raw direction/status and normalize later.
- `Verify`: verification method code. Common values include fingerprint/card/face depending on device model.
- `Workcode`: optional work code.
- Reserved fields should be preserved in raw metadata when useful but are not required for initial processing.

## Important Commands

The project needs only a small command subset for the first real-device flow:

- `C: <CmdID>: LOG`
  - Ask the device to check and transmit new attendance data immediately.

- `C: <CmdID>: CHECK`
  - Ask the device to reread options and reupload data according to timestamp settings.

- `C: <CmdID>: DATA QUERY ATTLOG StartTime=<time>\tEndTime=<time>`
  - Ask the device to query attendance records for a time range.

- `C: <CmdID>: SET OPTION <Key>=<Value>`
  - Set one client option.

- `C: <CmdID>: RELOAD OPTIONS`
  - Ask the device to reload configuration.

## Integration Scope For This App

Implemented / first-priority scope:

- Initialization response.
- Attendance log upload.
- Device heartbeat / last-seen tracking.
- Command queue with `LOG`.
- Command acknowledgement storage.
- Serial-number-based device lookup or auto-create.
- Device-user mapping during raw log import.

Later scope:

- Attendance photos.
- User push/sync to device.
- Fingerprint/face/palm template sync.
- Cross-device `BIODATA` sync through the server.
- Remote enrollment.
- Remote attendance.
- Firmware/file commands.
- Encrypted communication.

## BIODATA Sync Note

The protocol includes enough primitives to synchronize biometric templates between devices through the server, but it does not describe this as a direct device-to-device transfer.

Expected future flow:

1. Device A uploads biometric templates to the server with `POST /iclock/cdata?table=BIODATA`.
2. The app stores each template by employee/device PIN, biometric type, template number, format, version, and payload.
3. The app queues `DATA UPDATE BIODATA` commands for Device B, Device C, or any selected target device.
4. Target devices poll `/iclock/getrequest`, receive the queued commands, write the templates locally, and report results through `/iclock/devicecmd`.

This should be completed only after a real ZKTeco device is available, because actual model behavior may vary by biometric type, algorithm version, template format, payload size, and firmware support.

## Operational Notes

- Endpoints must be public and excluded from CSRF checks because physical devices are not browser clients.
- Responses should be `text/plain`; many devices expect exact plain text.
- The device initiates all requests, so a server behind NAT is fine only if the device can reach its public URL/IP and port.
- Real-device tests should verify whether the model sends spaces inside timestamps, extra columns, identity-card fields, or different status/verify codes.
- Raw device data should be stored before interpretation. Attendance calculation should consume normalized raw logs later.
