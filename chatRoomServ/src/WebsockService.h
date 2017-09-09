#pragma once

#include <wtypes.h>

//导出API函数时使用下面的宏定义
#ifndef DLLEXPORT_API
	#define DLLEXPORT_API extern "C" __declspec(dllexport) 
#endif
//导出类时使用下面的宏定义
#ifndef DLLEXPORT_CLASS
	#define DLLEXPORT_CLASS __declspec(dllexport) 
#endif

//导出类时使用下面的宏定义
#ifndef DLLEXPORT_MULT
#define DLLEXPORT_MULT __declspec(dllexport) 
#endif

typedef void(WINAPI* WEBSOCK_SERVICE_ACCEPT_CALLBACK)(HANDLE handle, char* pszIP, WORD wPort);
typedef void(WINAPI* WEBSOCK_SERVICE_RECV_CALLBACK)(HANDLE handle, int nLen, char* pData);
typedef void(WINAPI* WEBSOCK_SERVICE_DISCONNECT_CALLBACK)(HANDLE handle);

DLLEXPORT_API BOOL WINAPI WebsockServiceInit(WEBSOCK_SERVICE_ACCEPT_CALLBACK pfnAcceptCallback, 
											 WEBSOCK_SERVICE_RECV_CALLBACK pfnRecvDataCallback,
											 WEBSOCK_SERVICE_DISCONNECT_CALLBACK pfnDisconnectCallback, 
											WORD wPort);
DLLEXPORT_API VOID WINAPI WebsockServiceDestory();
DLLEXPORT_API BOOL WINAPI WebsockServiceSend(HANDLE handle, char* sendBuf);
DLLEXPORT_API BOOL WINAPI WebsockServiceDisconnect(HANDLE handle);

DLLEXPORT_API char* WINAPI WebsockServiceGetPeerIP(HANDLE handle, char* pszIp);
DLLEXPORT_API WORD WINAPI WebsockServiceGetPeerPort(HANDLE handle);
