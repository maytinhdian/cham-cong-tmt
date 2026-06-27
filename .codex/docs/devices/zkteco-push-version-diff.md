# ZKTeco PUSH Version Diff

Sources:

- `ZkTecoPUSH-Communication-Protocol-20200325.pdf` - Attendance PUSH Communication Protocol, Software Version 2.4.1, Doc Version 3.7, March 2020.
- `ZKTecoPUSH-Communication-Protocol-20240112.pdf` - Security PUSH Communication Protocol, PUSH Protocol Version 3.1.2, Doc Version 4.8, January 2024.

## Executive Summary

Bản 2020 là tài liệu Attendance PUSH, tập trung vào máy chấm công và các bảng attendance như `ATTLOG`, `ATTPHOTO`, `OPERLOG`, `BIODATA`, `USERPIC`, `BIOPHOTO`, `ERRORLOG`.

Bản 2024 đổi phạm vi thành Security PUSH. Nó vẫn nhắc `DeviceType=att`, nhưng tài liệu chính nghiêng mạnh về access control/security: đăng ký thiết bị, registry code, token/session, real-time events, real-time status, access-control transaction, channel controller, Wiegand 2.0, video intercom, NTP, health QR, mask/temperature, elevator/channel-controller commands, và extended event codes.

Tích hợp hiện tại của TMT đang đi theo subset Attendance PUSH 2020: `/iclock/cdata?options=all`, `/iclock/cdata?table=ATTLOG`, `/iclock/getrequest`, `/iclock/devicecmd`, `/iclock/ping`. Subset này vẫn phù hợp cho mục tiêu nhập log chấm công. Nếu muốn hỗ trợ các thiết bị firmware/security mới theo tài liệu 2024, cần thêm một compatibility layer riêng thay vì thay thế ngay flow `ATTLOG`.

## Document-Level Changes

| Area | 2020 Attendance PUSH | 2024 Security PUSH | Impact |
| --- | --- | --- | --- |
| Scope | Attendance device and access-control device data exchange, but examples are attendance-first. | Security/access-control first, broader device family and controller features. | Do not assume all 2024 devices push `ATTLOG`; many examples use security tables. |
| Version label | Software Version `2.4.1`, Doc Version `3.7`. | PUSH Protocol Version `3.1.2`, Doc Version `4.8`. | Version naming changed from software/doc to protocol/doc. |
| Page count | 116 pages. | 282 pages. | 2024 adds large access-control command surface and appendices. |
| Encoding | Mixed historical behavior, with device-language considerations in some fields. | Revision history says unified UTF-8 was clarified in V3.8, but some table field notes still mention older language-specific behavior. | Server parser should remain tolerant of UTF-8 and legacy encodings in names. |

## Initialization And Registration

### 2020

The device initializes with:

```http
GET /iclock/cdata?SN=...&options=all&pushver=...&language=...&pushcommkey=...
```

Server returns a plain-text options block beginning with `GET OPTION FROM: <SN>`. Important fields include:

- `ATTLOGStamp`, `OPERLOGStamp`, `ATTPHOTOStamp`
- `ErrorDelay`
- `Delay`
- `TransTimes`
- `TransInterval`
- `TransFlag`
- `TimeZone`
- `Realtime`
- `Encrypt`
- `ServerVer`
- `PushProtVer`

### 2024

Initialization introduces explicit device registration. A device that is not registered gets a simple `OK`, then calls:

```http
POST /iclock/registry?SN=...
```

After registration, server configuration includes newer fields:

- `registry=ok`
- `RegistryCode`
- `ServerVersion`
- `ServerName`
- `PushProtVer`
- `ErrorDelay`
- `RequestDelay`
- `TransTimes`
- `TransInterval`
- `TransTables`
- `Realtime`
- `SessionID`
- `TimeoutSec`

Key change: `Delay` becomes `RequestDelay`, `TransFlag` is replaced by `TransTables` in the security flow, and registered devices use registry/session concepts.

## Upload Data Changes

### Attendance-first upload in 2020

The main attendance log upload remains:

```http
POST /iclock/cdata?SN=...&table=ATTLOG&Stamp=...
```

The server currently implemented in this project follows this model.

Important 2020 upload tables:

- `ATTLOG`: attendance record
- `ATTPHOTO`: attendance photo
- `OPERLOG`: operation log and several data-like uploads
- `IDCARD`: identity card information
- `BIODATA`: unified biometric template
- `USERPIC`: user photo
- `BIOPHOTO`: comparison photo
- `ERRORLOG`: error log

### Security/access-control upload in 2024

The 2024 document uses different upload surfaces for the main security flow:

- `POST /iclock/cdata?SN=...&table=rtlog` for real-time access events.
- `POST /iclock/cdata?SN=...&table=rtstate` for real-time status.
- `POST /iclock/cdata?SN=...&table=tabledata&tablename=user&count=...` for user data.
- `tabledata` with `tablename=identitycard`, `templatev10`, `biophoto`, `biodata`, `transaction`, and other security tables.
- `POST /iclock/cdata?SN=...&table=transaction&count=...&datafmt=3&Stamp=...` for compressed transaction account upload.

For attendance-log import, the practical compatibility risk is that a newer security-mode device may send access-control-style `rtlog` or `transaction` rows instead of `ATTLOG` rows.

## Command And Query Changes

### 2020

The server returns commands from:

```http
GET /iclock/getrequest?SN=...
```

Common command families:

- `DATA UPDATE`
- `DATA DELETE`
- `DATA QUERY`
- `CLEAR`
- `CHECK`
- `INFO`
- `GET/PUTFILE`
- `ENROLL_*`
- `CONTROL`
- `LOG`

Device command replies go to:

```http
POST /iclock/devicecmd?SN=...
```

### 2024

`GET /iclock/getrequest?SN=...` and `POST /iclock/devicecmd?SN=...` remain, but server command coverage is much larger:

- `DATA UPDATE`, `DATA DELETE`, `DATA COUNT`, `DATA QUERY`
- `ACCOUNT`
- `PULL SDK DEVICE`
- `CONTROLLER`
- `TEST HOST`
- `CONTROL DEVICE`
- `UPGRADE`
- `SET OPTIONS`
- `GET OPTIONS`
- `REMOTE REGISTRATION`

Query result upload is formalized through:

```http
/iclock/querydata?SN=...&type=count|tabledata|options&cmdid=...&tablename=...
```

This is a major difference from the smaller attendance-focused command flow.

## Biometric And Photo Changes

2020 already includes unified templates through `BIODATA`, user photos, comparison photos, remote enrollment, and visible-light face support.

2024 expands and clarifies biometric handling:

- Visible light palm is added as biometric `type=10`.
- `BIOPHOTO` becomes an optional field in `ENROLL_BIO`.
- Unified template commands include more detailed update/delete/count/query behavior.
- `Majorver` / `Minorver` naming was corrected to `MajorVer` / `MinorVer`.
- Multi-biometric support flags and examples include more modalities.

For TMT, this remains future scope until real devices are available. The attendance-log integration does not need to store biometric templates yet.

## Events And Access Control Changes

2020 contains attendance and operation-log oriented event handling.

2024 adds a much larger event model:

- Real-time event upload through `rtlog`.
- Real-time status upload through `rtstate`.
- Extended event code ranges:
  - `4000 <= event < 5000`: normal extended events.
  - `5000 <= event < 6000`: abnormal extended events.
  - `6000 <= event < 7000`: warning extended events.
- Appendix 19 adds extended real-time events.
- Channel controller upload protocols and Appendix 20 are added.
- Elevator control, expansion boards, time rules, passing modes, Wiegand 2.0, and video intercom contact-list protocols are added.

These are not needed for the current attendance-log scope, but they matter if the app later manages access-control events or controller hardware.

## Security And Encryption

Both documents describe public-key/factor exchange for communication encryption.

Version support differs:

- 2020 Attendance PUSH: encryption support is described for Attendance PUSH `2.4.0` and above.
- 2024 Security PUSH: encryption support is described for Access Control PUSH `3.1.1` and above.

The current implementation still uses `Encrypt=None`. Keep it that way until real-device testing confirms encrypted PUSH is required.

## Practical Implementation Notes For TMT

1. Keep the existing `ATTLOG` parser as the primary attendance integration path.
2. Accept that `ZKTecoPUSH-Communication-Protocol-20240112.pdf` is not a drop-in replacement for the attendance PDF; it is a broader security protocol.
3. Add support for `registry`, `RegistryCode`, `SessionID`, `RequestDelay`, and `TransTables` only when a real device requires the 2024 flow.
4. Consider adding a future parser for `table=rtlog` and `tablename=transaction` if security/access-control devices need to feed attendance-like events.
5. Treat `querydata` as future work for advanced server commands such as count/query/options responses.
6. Keep biometric sync as deferred until hardware testing validates `BIODATA`, `BIOPHOTO`, and `ENROLL_BIO` payload behavior.

## Version Timeline Highlights

### 2020 Attendance PUSH history through V3.7

- V3.7, 2020-03-20: hybrid identification; modified initialization/config protocols; changed comparison-photo delivery; added query/clear unified template; added heartbeat.
- V3.6, 2019-08-02: exception/error log protocol.
- V3.5, 2019-05-30: identity-card attendance record/photo and blacklist protocols.
- V3.4, 2018-10-08: communication encryption key/factor exchange.
- V3.3, 2018-08-09: work code and comparison photo flags; online card/biometric enrollment; visible-light face template type; online update; background verification.
- V3.2, 2017-11-10: serial-number description and `BIODATA` support in initialization response.

### 2024 Security PUSH history after the 2020 baseline

- V4.8, 2024-01-12: extended event codes `4009-4013` and `6008-6010`; optional `BIOPHOTO` for `ENROLL_BIO`; Wiegand 2.0; video intercom contact-list protocols.
- V4.6, 2023-07-14: remote registration changes; unified template explanation; event codes `6006-6007`; AccSupportFunList position `62`; user validity range distribution for access-control privilege.
- V4.2, 2023-01-07: event codes `4008` and `6005`; `DevNSLevel` and `SvrNSLevel`; NTP server command and `NtpFunOn`; verification modes `25-29`; visible-light palm type `10`.
- V3.8, 2022-05-20: `MajorVer` / `MinorVer` naming fix; more event codes; `TIPS` in remote identification response; error code `-30`; health QR code verification; UTF-8 clarification; alarm-field description change.
- V2.9, 2021-07-28: many event codes; new control-device AA values; elevator/expansion-board/time-rule/passing-mode protocols; more registration capability flags; elevator upload/settings; channel controller protocols.
- V2.3, 2021-01-06: more event codes; VMS credentials; new access-control verification rules; temperature measurement; QR code encryption; remote registration.
- V1.8, 2020-07-30: subcontracting upgrade switch and protocol; `sitecode` and `linkid` descriptions for real-time events.
- V1.7 / V1.6, 2020-04 and 2020-03: more real-time event codes and expanded alarm bits.
- V1.5, 2020-03-20: hybrid identification, unified template delivery/delete/count/query, comparison-photo query/delivery changes, URL mode for user photo.
