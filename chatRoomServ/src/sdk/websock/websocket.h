#ifndef _WEBSOCKET_HANDSHAKE_H_
#define _WEBSOCKET_HANDSHAKE_H_

#ifdef __cplusplus
extern "C"{
#endif

#include<string.h>
#include<stdlib.h>

#ifndef _WIN32
	#ifndef strcmpi
	#define strcmpi     strcasecmp
	#endif 
#else
	#ifndef strtok_r
	#define strtok_r    strtok_s
	#endif 
#endif

typedef enum _EzhWebSocketMethod
{
	WEB_SOCKET_HANDSHAKE_METHOD_UNKNOW,
	WEB_SOCKET_HANDSHAKE_METHOD_1,  //safari
	WEB_SOCKET_HANDSHAKE_METHOD_2	//chrome,firefox
}EzhWebSocketMethod;

typedef struct _TzhWebSocket 
{
	EzhWebSocketMethod method;
	char *resource;
	char *host;
	char *origin;
	char *protocol;
	char *key;
	char *key1;
	char *key2;
	char *version;
}TzhWebSocket;

//去除右空格
char *zhWebSockLTrim( char *str);
//去除左空格 
char *zhWebSockRTrim( char *str);
//去除两边空格
char *zhWebSockTrim(char *str);

//搜索字符变量内容
char* zhWebSockMatchString(const char* src, const char* pattern, char end);

//握手包处理---------------------BEGIN------------------

//握手协议 safari
//=0 成功
//=1 失败

int zhWebSockHandshake_1(const char* src,TzhWebSocket* hs,char* acceptBuf);
//握手协议 chrome firefox ie10
//=0 成功
//=1 失败
int zhWebSockHandshake_2(const char* src,TzhWebSocket* hs,char* acceptBuf);
//握手包处理-----------------------END----------------

//收取包处理---------------------BEGIN------------------

//safari 开始结束尾  0x00-0xff
int zhWebSockPackMethod_1(const unsigned char* cache,int cache_len,unsigned char* packet,int* nPacket);

/*chrome firefox ie10的协议 
0x81开头 
第二个字节 (cache[1] & 0x80) == 0x80 ,为数据标识
第二个字节 nCode=cache[1]&0x7f ,有126,127,普通,三种
根据第二个字节nCode确定,第几位开始是数据加密钥匙,占4个字节
*/
int zhWebSockPackMethod_2(const unsigned char* cache,int cache_len,unsigned char* packet,int* nPacket);
//收取包处理---------------------END------------------

/*
   协议鉴别  老版本还是新版本
   return 
       1为新版本 
	   2为老版本 
	   0非协议
   src
       要解析的数据
*/
EzhWebSocketMethod zhWebSockIdentify(const char* buf,int buflen);


///////////////////////////////////////////////////////////////////////
//外部函数
//初始化对象
int zhWebSockInit(TzhWebSocket* hs);

//获取判断
//正确获取WEBSOCKET头信息返回0且acceptBuf为socket要返回的SOCKET信息,错误返回-1 ,已经握手成功返回1
int zhWebSockHandshake(const char* recvbuf,int buflen,TzhWebSocket* hs,char* acceptBuf);

//释放握手信息
void zhWebSockFree(TzhWebSocket* hs);

//发包
void zhWebSockSendData(const TzhWebSocket* hs,const char*sendBuf,int sendLen,char* sendData,int* dataLen);

/*
如果解包正常，返回整个数据包的总长度,否则数据是不完整或者不匹配
char* packet 获取到最终数据字节
int* nPacket 最终数据的长度 
int*frame_begin_pos 在缓冲中的开始字节,包括不同版本的websocket的数据帧标识
int*frame_len  包括不同版本的websocket的数据帧的长度
返回
 =0 正常
 >0 整条数据帧的字节数,也是在缓冲区中要删除的字节
*/
int zhWebSockRecvPack(const TzhWebSocket* hs,const char* cache,int cache_len,char* packet,int* packet_len,int*frame_begin_pos,int*frame_len);


#ifdef __cplusplus
}
#endif

#endif