#include "socket.h"
#include "websocket.h"
#include "main2.h"

//开辟了1000个用户连接
#define CLIENT_MAX		1000
SOCKET s,tmps;
SOCKET sary[CLIENT_MAX]={0};//client
BOOL bTcpConnectedAry[CLIENT_MAX]={FALSE};
TzhWebSocket hs[CLIENT_MAX];
char recvCache[CLIENT_MAX][10240]={0};
int recvLen[CLIENT_MAX]={0};

//在线人数
int online_count=0;

void main2()
{
	main_init2();
	for(;;)
	{
		main_loop2();
		Sleep(1);
	}
	main_destory2();
}
void main_init2()
{	
	zhSockInit(&s,ZH_SOCK_TCP);
	zhSockBindAddr(s,NULL,1000);
	zhSockSetNonBlocking(s,1);
	zhSockListen(s);
	printf("initizal ok...\n");
	printf("bind port=1000\n");
}
void main_destory2()
{	
	int n=0;
	//释放内存
	for(n=0;n<CLIENT_MAX;n++)
	zhWebSockFree(&hs[n]);
}

void main_loop2()
{
    char recvTmp[102400];
	int nRet,n;
	
	if(tmps=zhSockAccept(s))
	{
		int nnn=0;
		for(nnn=0;nnn<CLIENT_MAX;nnn++)
		{
			if(FALSE==bTcpConnectedAry[nnn])//是否连接成功的
			{
				sary[nnn]=tmps;
				zhWebSockInit(&hs[nnn]);
				bTcpConnectedAry[nnn]=TRUE;
				online_count++;
				break;
			}
		}
	}
	for(n=0;n<CLIENT_MAX;n++)
	{
		nRet=zhSockRecv(sary[n],recvTmp,sizeof(recvTmp));
			
		if(nRet>0)
		{
			int ret;
			char acceptBuf[1024]={0};
			ret=zhWebSockHandshake(recvTmp,nRet,&hs[n],acceptBuf);
            if(ret==0)
			{
					//等于0就是握手数据
					//printf("接入新客户端\n");
					zhSockSend(sary[n],acceptBuf,strlen(acceptBuf));	
					//如果有接收缓冲区,在握手后要清空所有内容

					////////////////////////////
					{
						int a;
						char str[1000];
						//循环发送给所有客户端
						for(a=0;a<CLIENT_MAX;a++)
							if(TRUE==bTcpConnectedAry[a])//是否连接成功的
							{
								if(n==a)
								{
									//发送新用户信息
									sprintf(str,"{\"cmd\":0,\"online_count\":%d}",online_count);
									zhWebSockSendData(&hs[a],str,strlen(str),recvTmp,&nRet);
									zhSockSend(sary[a],recvTmp,nRet);
								}
								else
								{
									//发送旧用户新来了一个鸟人
									char str[1000];
									sprintf(str,"{\"cmd\":1,\"online_count\":%d}",online_count);
									zhWebSockSendData(&hs[a],str,strlen(str),recvTmp,&nRet);
									zhSockSend(sary[a],recvTmp,nRet);
								}
							}
					}
					////////////////////////////////
			}
			else if(ret==1)
			{
					int a;
					int totle,frame_begin,frame_len;
					char str[2048]={0}; 
					int len;
				
					//数据缓存
					memcpy(&recvCache[n][recvLen[n]],recvTmp,nRet);
					recvLen[n]+=nRet;

					//如果要解决粘包totle是要在缓冲区减去的字节数,这里没有处理粘包
					totle=zhWebSockRecvPack(&hs[n],recvCache[n],recvLen[n],str,&len,&frame_begin,&frame_len);
					if(totle>0)
					{
							//循环发送给所有客户端
							for(a=0;a<CLIENT_MAX;a++)
							{
								if(TRUE==bTcpConnectedAry[a])//是否连接成功的
								{
									zhWebSockSendData(&hs[a],str,len,recvTmp,&nRet);
									zhSockSend(sary[a],recvTmp,nRet);
								}
							}		
						//printf("传输数据来了totle=%d frame_begin=%d frame_len=%d len=%d %s\r\n",totle,frame_begin,frame_len,len,str);
					}
					//删除处理过后的数据
					recvLen[n]-=totle;
					memcpy(&recvCache[n][0],&recvCache[n][totle],recvLen[n]);
			}
		}
		else if(nRet==-1)
		{
			//disconnect
			if(TRUE==bTcpConnectedAry[n])
			{
				bTcpConnectedAry[n]=FALSE;
				online_count--;
				//printf("断开一个客户端\n");
				/////////////////////////
				{
						//告诉其它人.有人走了
						int a;
						char str[1000];
						for(a=0;a<CLIENT_MAX;a++)
						if(TRUE==bTcpConnectedAry[a])//是否连接成功的
						{
								
								//发送旧用户走了个人
								sprintf(str,"{\"cmd\":2,\"online_count\":%d}",online_count);
								zhWebSockSendData(&hs[a],str,strlen(str),recvTmp,&nRet);
								zhSockSend(sary[a],recvTmp,nRet);
						}
				}
				//////////////////////////////
			}
		}
	}
}
