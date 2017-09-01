// TestGCSRTNet.cpp : 定义控制台应用程序的入口点。
//

#include "stdafx.h"
#include "time.h"
#include "WebsockService.h"
#include <vector>
using namespace std;

vector<string> listBuf; //最后几条记录
vector<HANDLE> lstUser;

//接收客户端的连接请求的回调函数
void WINAPI AcceptCallBack(HANDLE handle, char* pszIP, WORD wPort);
//断开客户端连接的回调函数s
void WINAPI DissconnectCallBack(HANDLE handle);
//接收到数据包时的回调函数
void WINAPI RecvDataCallBack(HANDLE handle, int nLen, char* pData);

//接收客户端的连接请求的回调函数
void WINAPI AcceptCallBack(HANDLE handle, char *pszIP, WORD wPort)
{
	_tprintf(_T("AcceptCallBack-->handle=%p, pszIP=%s, wPort=%04d \n"), handle, pszIP, wPort);	

	char str[1000]={0};

	//发送新用户信息
	sprintf(str,"{\"cmd\":0,\"online_count\":%d}",lstUser.size()+1);
	WebsockServiceSend(handle, str);

	for(int i=0;i<listBuf.size();i++)
	{
		sprintf(str,"%s",listBuf[i].c_str());
		WebsockServiceSend(handle, str);
	}
	//发送旧用户新来了一个鸟人
	for(int i=0;i<lstUser.size();i++)
	{		
		sprintf(str,"{\"cmd\":1,\"online_count\":%d}",lstUser.size()+1);
		WebsockServiceSend(lstUser[i], str);
	}
	lstUser.push_back(handle);
}
//断开客户端连接的回调函数
void WINAPI DissconnectCallBack(HANDLE handle)
{	
	//直接退出,或放入重链表
	_tprintf(_T("DissconnectCallBack-->handle=%p\n"), handle);

	char str[1000]={0};
	int onlineCount=lstUser.size()-1;
	vector<HANDLE>::iterator it;
	for(it=lstUser.begin();it!=lstUser.end();)
	{
		if(*it==handle)
		{
			it=lstUser.erase(it);
		}
		else
		{
			sprintf(str,"{\"cmd\":2,\"online_count\":%d}",onlineCount);
			WebsockServiceSend(*it, str);
			it++;
		}
	}
}

//接收到数据包时的回调函数
void WINAPI RecvDataCallBack(HANDLE handle, int nLen, char* pData)
{
	char ip[32];
	WebsockServiceGetPeerIP(handle,ip);

	pData[nLen]=0;
	_tprintf(_T("Recv Socket=%p  ip=%s , nLen=%d, %s , time=%d\n\n"),handle,ip, nLen,pData,time(NULL));

	//保留最后几条记录
	if(listBuf.size()>=10)
	{
		listBuf.erase(listBuf.begin());
	}
	listBuf.push_back(pData);

	vector<HANDLE>::iterator it;
	for(it=lstUser.begin();it!=lstUser.end();it++)
	{
		//返回到客户端
		WebsockServiceSend(*it,pData);
	}
}

int _tmain(int argc, _TCHAR* argv[])
{
	_tprintf(_T("The websocket is server.\n"));
	if(!WebsockServiceInit(AcceptCallBack,RecvDataCallBack,DissconnectCallBack, 1000))
	{
		_tprintf(_T("WebsockNetInit failed as server.\n"));
		getchar();
		return 0;
	}

	int nExitCode;
	while(true)
	{
		scanf( "%d", &nExitCode);
		if(nExitCode == 0)
		{
			break;
		}
	}

	WebsockServiceDestory();

	return 0;
}