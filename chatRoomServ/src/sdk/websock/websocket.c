#include "md5.h"
#include "stdio.h"
#include "sha1.h"
#include "c_base64.h"
#include "websocket.h"

///////////////////////////////
//去除字符串空格
char *zhWebSockLTrim( char *str ) {
    /**去除左边空格**/
    int length;
    char *i;
    char *len;
    int m = 0;
    int n = 0;

	if(NULL==str){return NULL;}

	length = strlen( str );
    i = str;
    len = str + length;
    
    for (; i<len; i++ ) {
        if ( *i == ' ' || *i == '\t' || *i == '\n' ) {
            n ++;
        } else {
            break;
        }
    }
    for ( m=0; m<=length-n; m++ ) {
        *(str + m) = *(str + n + m);
    }
    return str;
}        

/**去除右边空格**/
char *zhWebSockRTrim( char *str) {
    char *i;
	
	if(NULL==str){return NULL;}

    i = str + strlen( str ) - 1;
    
    for (; i>=str; i-- ) {
        if ( *i == ' ' || *i == '\t' || *i == '\n' ) {
            *(str + strlen(str) -1) = '\0';
        } else {
            break;
        }
    }
    return str;                                                                                                                            
}

/**去除两边空格**/
char *zhWebSockTrim(char *str)
{
    zhWebSockLTrim(str);
    zhWebSockRTrim(str);
    return str;
}


// 增加了一个end参数，这样不必提取出字符串后，再做剔除处理
char* zhWebSockMatchString(const char* src, const char* pattern, char end){
        char buf[1024];
		int src_len,ptn_len,ret_len;
		unsigned short b=0, p=0, i=0;
		char c;
		char *ret_p;
        memset(buf, 0, sizeof(buf));
        src_len = strlen(src); 
        ptn_len = strlen(pattern);
        
        for(i=0; i<src_len; i++){
                c = src[i];
                if(p==ptn_len){ // p==ptn_len 表示正在匹配中
                        if(c=='\r' || c=='\n'  || (end !='\0' && c==end) ) p++; // 匹配结束
                        else buf[b++]=c; // 匹配到的字符 
                }else if(p<ptn_len){ // 为达到匹配要求
                        if(c==pattern[p]) p++;
                        else p=0;
                }
        }
         ret_len = strlen(buf);
         
        if( ret_len>0 ){
                ret_p = (char*)malloc(ret_len+1); // 加 1 为了存储 '\0'
				memset(ret_p,0,ret_len+1);
                memcpy(ret_p, buf, ret_len);
        }else ret_p = NULL;
        return ret_p; 
}
///////////


///握手函数
int zhWebSockHandshake_1(const char* src, TzhWebSocket* hs,char* acceptBuf)
{
		char response[1024]={0};
        char *pstr;
		int j=0,i=0 ;
		char key3[8]={0};
		char digits1[64]={0}, digits2[64]={0}, c={0};
        int spaces1 = 0, spaces2 = 0;
        int key1_len, key2_len;
        short d1 = 0, d2 = 0;
        unsigned int result1, result2;
        unsigned char chrkey1[4]={0}, chrkey2[4]={0};
		unsigned char raw[16]={0}, dig[16]={0};
		char handshake_str[1024]={0};
		int handshake_len;
        
		//检测HTTP标识是否完整
		pstr  =(char *)strstr(src,"\r\n\r\n") ;
		if(NULL==pstr){return 1;}
		*(pstr)=0;
		pstr+=4;
		// 获取 key3，即最后的8位字符
		memcpy(key3,pstr,8);

		hs->method		= WEB_SOCKET_HANDSHAKE_METHOD_1;		
		////提取出各项的值填充 handshake结构体
        hs->resource    = zhWebSockMatchString(src, "GET ", 0x20); // 提取空格之前
        hs->host        = zhWebSockTrim(zhWebSockMatchString(src, "Host:", '\0'));
        hs->origin      = zhWebSockTrim(zhWebSockMatchString(src, "Origin:", '\0'));
        hs->protocol    = zhWebSockTrim(zhWebSockMatchString(src, "Sec-WebSocket-Protocol:", '\0'));
        hs->key1        = zhWebSockTrim(zhWebSockMatchString(src, "Sec-WebSocket-Key1:", '\0'));
        hs->key2        = zhWebSockTrim(zhWebSockMatchString(src, "Sec-WebSocket-Key2:", '\0')); 
        
        
        /////////计算返回码部分
        /*
		  取出Sec-WebSocket-Key1中的所有数字字符形成一个数值，然后除以Key1中的空格得到一个数值，保留该数值整数位，得到数值result1；
		  对Sec-WebSocket-Key2如法炮制，得到第二个整数result2；
		  把result1和result2按照Big-Endian字符序列连接起来，然后再与另外一个Key3连接，得到一个原始序列raw。
		  那么Key3是什么呢？大家可以看到在Safari发送过来的握手请求最后，有一个8字节的奇怪的字符串，这个就是Key3。
		  回到raw，对这个原始序列做zhWebSockMD5算出一个16字节长的dig，这就是老版本协议需要的token
		*/
		
        key1_len = strlen(hs->key1);
        key2_len = strlen(hs->key2);
        
        for (i = 0; i < key1_len; i++){ 
                c = hs->key1[i];
                if (c == 0x20) spaces1++;
                else if(c>='0' && c<='9') digits1[d1++]=c; 
        }
        for (i = 0; i < key2_len; i++){ 
                c = hs->key2[i];
                if (c == 0x20) spaces2++;
                else if(c>='0' && c<='9') digits2[d2++]=c; 
        }
        result1 = (unsigned int) (strtoul(digits1, NULL, 10) / spaces1);
        result2 = (unsigned int) (strtoul(digits2, NULL, 10) / spaces2);
       
        
        for (i = 0; i < 4; i++) chrkey1[i] = result1 << (8 * i) >> (8 * 3);
        for (i = 0; i < 4; i++) chrkey2[i] = result2 << (8 * i) >> (8 * 3);
     
        memcpy(raw, chrkey1, 4);
        memcpy(&raw[4], chrkey2, 4);
        memcpy(&raw[8], key3, 8);
        //计算的zhWebSockMD5值
        MDData((char*)raw, 16, (char*)dig);
 
	   //构造恢复http头
        sprintf(handshake_str,	"HTTP/1.1 101 WebSocket Protocol Handshake\r\n"
								"Upgrade: WebSocket\r\n"
								"Connection: Upgrade\r\n"
								"Sec-WebSocket-Origin: %s\r\n" 
								"Sec-WebSocket-Location: ws://%s%s\r\n"
								"Sec-WebSocket-Protocol: sample\r\n\r\n",
								hs->origin, hs->host, hs->resource);
       
        handshake_len=strlen(handshake_str);
        for (i = 0; i < handshake_len; i++) acceptBuf[i] = handshake_str[i];
        for (j = 0; j < 16; i++, j++) acceptBuf[i] = dig[j];
		acceptBuf[i]=0;

		return 0;
}

int zhWebSockHandshake_2(const char* src,TzhWebSocket* hs,char* acceptBuf)
{  
		char *pstr;
		char buf[60]={0};
		size_t i=0,j=0;
		char res[256]={0};
		char e[24];//这个变量才对
		SHA1Context sha;
		char msg[256]={0};

		//检测HTTP标识是否完整
		pstr  =(char *)strstr(src,"\r\n\r\n") ;
		if(NULL==pstr){return 1;}
		*(pstr)=0;

		hs->method			= WEB_SOCKET_HANDSHAKE_METHOD_2;
		hs->resource		= zhWebSockMatchString(src, "GET ", 0x20); // 提取空格之前
		hs->host			= zhWebSockTrim(zhWebSockMatchString(src, "Host:", '\0'));
		hs->origin          = zhWebSockTrim(zhWebSockMatchString(src, "Origin:", '\0'));
	    
		hs->key				= zhWebSockTrim(zhWebSockMatchString(src, "Sec-WebSocket-Key:", '\0'));
		hs->version         = zhWebSockTrim(zhWebSockMatchString(src, "Sec-WebSocket-Version:", '\0'));

		sprintf(msg,"%s%s",hs->key,"258EAFA5-E914-47DA-95CA-C5AB0DC85B11");
		//printf("%s\n",msg);

		 SHA1Reset(&sha);
		SHA1Input(&sha, (const unsigned char *) msg, (unsigned int)strlen(msg));

		if (SHA1Result(&sha))
		{
			sprintf(buf, "%08X%08X%08X%08X%08X",
			sha.Message_Digest[0],
			sha.Message_Digest[1],
			sha.Message_Digest[2],
			sha.Message_Digest[3],
			sha.Message_Digest[4]);
			//  printf( "%s\n",buf);

			memset(e,0,24);
			sscanf(buf,"%02X%02X%02X%02X%02X%02X%02X%02X%02X%02X%02X%02X%02X%02X%02X%02X%02X%02X%02X%02X",
			&e[0],&e[1],&e[2],&e[3],&e[4],&e[5],&e[6],&e[7],&e[8],&e[9],&e[10],
			&e[11],&e[12],&e[13],&e[14],&e[15],&e[16],&e[17],&e[18],&e[19]);
			//for(i=0;i<20;i++)
			//printf( "%02X",(unsigned char)e[i]);
			//printf("\n");
			base64_encode(e,20,res);
			sprintf(acceptBuf,	"HTTP/1.1 101 Switching Protocols\r\n"
								"Upgrade: WebSocket\r\n"
								"Connection: Upgrade\r\n"
								"Sec-WebSocket-Accept: %s\r\n\r\n", res);
			// printf("%s",(char*)res);
		}
		return 0;
}

EzhWebSocketMethod zhWebSockIdentify(const char* buf,int buflen)
{  
		EzhWebSocketMethod r;

		if(buflen<=4)
		{return WEB_SOCKET_HANDSHAKE_METHOD_UNKNOW;}

		if(strstr(buf,"Sec-WebSocket-Key1:"))
		{
			r=WEB_SOCKET_HANDSHAKE_METHOD_1;
		}
		else if(strstr(buf,"Sec-WebSocket-Key:"))
		{
			r=WEB_SOCKET_HANDSHAKE_METHOD_2;
		}
		else
		{
			r=WEB_SOCKET_HANDSHAKE_METHOD_UNKNOW;
		}
		return r;
}

int zhWebSockHandshake(const char* recvbuf,int buflen,TzhWebSocket* hs,char* acceptBuf)
{
		int ret;
		
		//已经握手过
		if(hs->method!=WEB_SOCKET_HANDSHAKE_METHOD_UNKNOW)
		{
			return 1;
		}

		ret=zhWebSockIdentify(recvbuf,buflen);
		switch(ret)
		{
		case WEB_SOCKET_HANDSHAKE_METHOD_UNKNOW:
			{
				return -1;
			}
				break;
		case WEB_SOCKET_HANDSHAKE_METHOD_1:
			{
				if(0==zhWebSockHandshake_1(recvbuf,hs,acceptBuf))
				{
					return 0;
				}
			}
				break;
		case WEB_SOCKET_HANDSHAKE_METHOD_2:
			{
				if(0==zhWebSockHandshake_2(recvbuf,hs,acceptBuf))
				{
					return 0;
				}
			}
				break;
		}
		return -1;
}

//释放握手后不再使用的部分变量
void zhWebSockFree(TzhWebSocket* hs)
{
        if( hs->resource != NULL )      free(hs->resource);
        if( hs->host != NULL )          free(hs->host);
        if( hs->origin != NULL )        free(hs->origin);
        if( hs->protocol != NULL )      free(hs->protocol);
		if( hs->key != NULL )			free(hs->key);
        if( hs->key1 != NULL )          free(hs->key1);
        if( hs->key2 != NULL )          free(hs->key2);
		if( hs->version != NULL )		free(hs->version);
}

//发包
void zhWebSockSendData(const TzhWebSocket* hs,const char*sendBuf,int sendLen,char* sendData,int* dataLen)
{
	switch(hs->method)
	{
	case WEB_SOCKET_HANDSHAKE_METHOD_UNKNOW:
		{
		
		}
		break;
	case WEB_SOCKET_HANDSHAKE_METHOD_1:
		{
			*dataLen=sendLen+2;
			sendData[0]=0x00;
			memcpy(&sendData[1],sendBuf,sendLen);
			sendData[sendLen+1]=0xff;
		}
		break;
	case WEB_SOCKET_HANDSHAKE_METHOD_2:
		{
			if( sendLen < 126 ){
				int i=0;
				sendData[0] = 0x81;
				sendData[1] = sendLen;
				memcpy(&sendData[2],sendBuf,sendLen);
				*dataLen=sendLen+2;
			}else if( sendLen <= 0xFFFF ){//用16位表示数据长度
				unsigned char short_buf[sizeof(unsigned short)];
				unsigned short short_len=sendLen;
				sendData[0] = 0x81;
				sendData[1] = 126;

				memcpy(&short_buf,&short_len,sizeof(unsigned short));
				short_len=short_len<<8|short_buf[1];
				memcpy(&sendData[2],&short_len,sizeof(unsigned short));

				memcpy(&sendData[4],sendBuf,sendLen);
				*dataLen=sendLen+4;
			}else{
				//用64位表示数据长度
				long int int_len=sendLen;
				sendData[0] = 0x81;
				sendData[1] = 127;
				memcpy(&sendData[2],int_len& 0xFFFF0000 >> 32,2);
				memcpy(&sendData[4],int_len& 0xFFFF,6);
				memcpy(&sendData[10],sendBuf,sendLen);
				*dataLen=sendLen+10;
			}
		}
		break;
	}
}

int zhWebSockRecvPack(const TzhWebSocket* hs,const char* cache,int cache_len,char* packet,int* packet_len,int*frame_begin_pos,int*frame_len)
{
	char *pbegin=NULL;
	int i;
	unsigned char*pCache;

	*frame_begin_pos=0;
	*frame_len=0;
	*packet_len=0;

	pCache=(unsigned char*)cache;

	switch(hs->method)
	{
	case WEB_SOCKET_HANDSHAKE_METHOD_UNKNOW:
		{
			return 0;
		}
	case WEB_SOCKET_HANDSHAKE_METHOD_1:
		{
			for(i=0;i<cache_len;i++)
			{
				if(pCache[i]==0x00)
				{
					pbegin=(char*)&pCache[i];
					break;
				}
			}
			if(NULL==pbegin){return 0;}

			*frame_begin_pos=i;
			*frame_len=zhWebSockPackMethod_1((unsigned char*)pbegin,cache_len,(unsigned char*)packet,packet_len);
			return *frame_begin_pos+*frame_len;
		}
	case WEB_SOCKET_HANDSHAKE_METHOD_2:
		{
			for(i=0;i<cache_len;i++)
			{
				if(pCache[i]==0x81)
				{
					pbegin=(char *)&pCache[i];
					break;
				}
			}
			if(NULL==pbegin){return 0;}

			*frame_begin_pos=i;
			*frame_len=zhWebSockPackMethod_2((unsigned char*)pbegin,cache_len,(unsigned char*)packet,packet_len);
			return *frame_begin_pos+*frame_len;
		}
	}
   return 0;
}

int zhWebSockPackMethod_1(const unsigned char* cache,int cache_len,unsigned char* packet,int* nPacket)
{
    int i=0;
	int j=0;

	//判断是否正常数据
	if(cache[0]!=0x00)
	{
		return 0;
	}

	while(0xFF!=cache[i++])
	{
		packet[j++]=cache[i];

		if(i>cache_len)//数据包是这样的0x00----  （没有0xff）这是不完整包
		{
			//清空packet nPacket=0
			memset(packet,0,j);
			*nPacket=0;
			return 0;
		}
	};
	*nPacket=i-2;
	packet[*nPacket]=0;
	return i;
	
}
int zhWebSockPackMethod_2(const unsigned char* cache,int cache_len,unsigned char* packet,int* nPacket)
{
    int i=0;
	char nCode;
	char mask_flag;
	char masks[4]={0};
	long int nData=0;
    int nHead=0;
	
	//判断是否正常数据
	if(cache[0]!=0x81)
	{
		return 0;
	}

	mask_flag = ((cache[1] & 0x80) == 0x80) ? 1 : 0;
	nCode=cache[1]&0x7f;
	if(nCode==126)
	{
		unsigned short tmp;
		nHead=8;
		memcpy(masks,&cache[4],4);
		tmp=(cache[2] << 8 | cache[3]);
		nData=tmp;
		if((nData+nHead)>cache_len)
		{
			return 0;
		}
		else
		{
			memcpy(packet,&cache[8],(int)nData);
		}
     
	 }
	else if(nCode==127)
	{   
		long int tmp;
		nHead=14;
        memcpy(masks,&cache[10],4);
		memcpy(&tmp,&cache[2],sizeof(long int));
		nData=tmp;
		if((nData+nHead)>cache_len)
		{
			return 0;
		}
		else
		{
			memcpy(packet,&cache[14],nData);
		}
	}
	else
	{   
		nHead=6;
		memcpy(masks,&cache[2],4);
        nData=nCode;
		if((nData+nHead)>cache_len)
		{
			return 0;
		}
		else
		{
			memcpy(packet,&cache[6],(int)nData);
		}
	}

	//解码
	for(i=0;i<nData;i++)
	{
	   packet[i]=packet[i]^masks[i%4];
	}

	*nPacket=(int)nData;
	return nData+nHead;
}

int zhWebSockInit(TzhWebSocket* hs)
{
	memset(hs,0,sizeof(TzhWebSocket));
	hs->method=WEB_SOCKET_HANDSHAKE_METHOD_UNKNOW;
}