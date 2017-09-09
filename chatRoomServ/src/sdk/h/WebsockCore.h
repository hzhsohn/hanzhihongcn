#pragma once
#include "WebsockDealQueMgr.h"
#include "WebsockDealQueMgr.h"
#include "WebsockMemManager.h"
#include "WebsockSockMgr.h"

class WebsockCore
{

public:
	static BOOL Init();
	static BOOL Destroy();
	
	static BOOL InitNet(WORD wPort);
	static BOOL InitListenSocket(WORD wPort);
	
	static DWORD WINAPI AcceptThread(void* pVoid);
	static DWORD WINAPI WorkDealThread( void *pVoid);
	static DWORD WINAPI DealRecvDataThread( void *pVoid);
	
	static HANDLE m_hRecvEvent;

private:
	static SOCKET	m_sListen;
	static WORD m_dwPacketNumber;
	
	static BOOL m_bActive;
};
