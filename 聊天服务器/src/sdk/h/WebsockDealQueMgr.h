#pragma once

#include <list>
#include "MemMgr.h"
#include "WebsockSockMgr.h"

using namespace std;

#define GCHMAC_FREE_WAITDEAL_COUNT			1000
#define GCHMAC_MAX_WAITDEAL_COUNT			10000

enum GCEM_OPERATE_TYPE
{
	GCE_OP_NONE,
	GCE_CLOSE_SOCKET,
	GCE_ACCEPT_COONECT,
};
struct GCSTH_RecvDataInfo
{
	void*				handle;
	DWORD				dwTickCount;		//���ڳ�ʱ����
	GCEM_OPERATE_TYPE	enOpType;			//��������
	int					nLen;
	char				buf[PACKET_LENGTH];
};

class WebsockDealQueMgr
{
public:
	static BOOL Init(void);
	static BOOL Destroy(void);

	static BOOL InsertWaitDealData(void *handle,GCEM_OPERATE_TYPE enOpType, int nLen, char* pBuf);
	static BOOL GetDealData(GCSTH_RecvDataInfo* pRecvDataInfo);
	static BOOL InsertOtherData(void *handle, GCEM_OPERATE_TYPE enOpType);

public:
	static list<GCSTH_RecvDataInfo*> m_lstWaitDealData;
	static list<GCSTH_RecvDataInfo*> m_lstDealData;

private:
	static CRITICAL_SECTION		m_cs;
	static int					m_nCurQueLen;
	static CMemMgr<GCSTH_RecvDataInfo>		m_memManager;

};
