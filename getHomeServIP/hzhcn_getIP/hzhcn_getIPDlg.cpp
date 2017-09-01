
// hzhcn_getIPDlg.cpp : 实现文件
//

#include "stdafx.h"
#include "hzhcn_getIP.h"
#include "hzhcn_getIPDlg.h"
#include "afxdialogex.h"
#include "zhHttp.h"
#include "c-json/js_parser.h"
#include <io.h>

using namespace std;

#ifdef _DEBUG
#define new DEBUG_NEW
#endif



CEdit g_txtIP;


// Chzhcn_getIPDlg 对话框
char*getCurrentPath(char*filename,char*dst_buf,int dst_buf_len)
{
  GetModuleFileNameA(NULL,dst_buf,dst_buf_len); 
  (strrchr(dst_buf, '\\'))[1] = 0; //删除文件名，只获得路径
 if(filename)
 { strcat_s(dst_buf,dst_buf_len,filename); }
 return dst_buf;
}

//返回值
//0=替换失败
//1=替换成功
//replace_str(strSrc,"我被替换了","靓仔",strDst);
//查找并替换字符串
int replace_str(const char *pInput,const char *pSrc,const char *pDst,char *pOutput)
{
  const char   *pi;
  const char *p;
  int nSrcLen, nDstLen, nLen;
  int ret;
  ret=0;
  // 指向输入字符串的游动指针.
  pi = pInput;
  // 计算被替换串和替换串的长度.
  nSrcLen = (int)strlen(pSrc);
  nDstLen = (int)strlen(pDst);
  // 查找pi指向字符串中第一次出现替换串的位置,并返回指针(找不到则返回null).
  p = strstr(pi, pSrc);
  if(p)
  {
    char *po; // 指向输出字符串的游动指针.
    po=(char*)malloc(strlen(pInput)+strlen(pDst)+1);
    // 计算被替换串前边字符串的长度.
    nLen = (int)(p - pi);
    // 复制到输出字符串.
    memcpy(po, pi, nLen);
    memcpy(po+nLen, pDst, nDstLen);
    strcpy(po+nLen+nDstLen, pi+nLen+nSrcLen);
    // 复制剩余字符串.
    strcpy(pOutput, po);
    free(po);
    po=NULL;
    ret=1;
  }
  else
  {
    // 没有找到则原样复制.
    strcpy(pOutput, pi);
  }
 return ret;
}
 

void doJson(char*buffer)
{
PJOBJECT root = NULL;

	int i = 0;
	PJVALUE value; PJSTRING str;
	char pt[100] = {0};
	Js_parser_object((void**)&root, buffer, &i);
	value = (PJVALUE)Js_object_get_value(root, "ip");
	if(value)
	if(value->value_type == JS_STRING)
	{
		str = (PJSTRING)value->value_data;
		Js_memset(pt, 0x0, 100);
		Js_strncpy(pt, str->str_data, str->str_len);
		g_txtIP.SetWindowText(pt);
	}
	Js_parser_object_free(root);
}


void httpCallBack(EzhHttpOperat operat,
						   char*host,
						   int port,
						   char*file,
						   char*parameter,
						   const char*body,
						   int body_len,
						   char*szBuf,
						   int nLen)
{
	switch(operat)
	{
	case ezhHttpOperatConnected:
		{
			TRACE("Connect Success\r\n");
		}
		break;
	case ezhHttpOperatGetData:
		{
			TRACE("Data nLen=%d {%%s}\r\n",nLen,szBuf);	

			doJson(szBuf);
		}
		break;
	case ezhHttpOperatGetSize:
		{
			TRACE("Data filesize=%d\r\n",nLen);
		}
		break;
	case ezhHttpOperatFinish:
		{
			TRACE("Finish\r\n");
		}
		break;
	case ezhHttpOperatRecviceFail:
		{
			TRACE("ezhHttpOperatRecviceFail!\r\n");
		}
		break;
	case ezhHttpOperatConnectFail:
		{
			TRACE("connect server fail!\r\n");
		}
		break;
	case ezhHttpOperatPostFail:
		{
			TRACE("ezhHttpOperatPostFail!!\r\n");
		}
		break;
	}
}



Chzhcn_getIPDlg::Chzhcn_getIPDlg(CWnd* pParent /*=NULL*/)
	: CDialogEx(Chzhcn_getIPDlg::IDD, pParent)
{
	m_hIcon = AfxGetApp()->LoadIcon(IDR_MAINFRAME);
}

void Chzhcn_getIPDlg::DoDataExchange(CDataExchange* pDX)
{
	CDialogEx::DoDataExchange(pDX);
	DDX_Control(pDX, IDC_EDIT1, g_txtIP);
}

BEGIN_MESSAGE_MAP(Chzhcn_getIPDlg, CDialogEx)
	ON_WM_PAINT()
	ON_WM_QUERYDRAGICON()
	ON_BN_CLICKED(IDOK, &Chzhcn_getIPDlg::OnBnClickedOk)
	ON_BN_CLICKED(IDCANCEL, &Chzhcn_getIPDlg::OnBnClickedCancel)
	ON_WM_DROPFILES() 
	ON_BN_CLICKED(IDC_BUTTON1, &Chzhcn_getIPDlg::OnBnClickedButton1)
END_MESSAGE_MAP()


// Chzhcn_getIPDlg 消息处理程序

BOOL Chzhcn_getIPDlg::OnInitDialog()
{
	CDialogEx::OnInitDialog();

	// 设置此对话框的图标。当应用程序主窗口不是对话框时，框架将自动
	//  执行此操作
	SetIcon(m_hIcon, TRUE);			// 设置大图标
	SetIcon(m_hIcon, FALSE);		// 设置小图标

	// TODO: 在此添加额外的初始化代码
	OnBnClickedOk();

	return TRUE;  // 除非将焦点设置到控件，否则返回 TRUE
}

// 如果向对话框添加最小化按钮，则需要下面的代码
//  来绘制该图标。对于使用文档/视图模型的 MFC 应用程序，
//  这将由框架自动完成。

void Chzhcn_getIPDlg::OnPaint()
{
	if (IsIconic())
	{
		CPaintDC dc(this); // 用于绘制的设备上下文

		SendMessage(WM_ICONERASEBKGND, reinterpret_cast<WPARAM>(dc.GetSafeHdc()), 0);

		// 使图标在工作区矩形中居中
		int cxIcon = GetSystemMetrics(SM_CXICON);
		int cyIcon = GetSystemMetrics(SM_CYICON);
		CRect rect;
		GetClientRect(&rect);
		int x = (rect.Width() - cxIcon + 1) / 2;
		int y = (rect.Height() - cyIcon + 1) / 2;

		// 绘制图标
		dc.DrawIcon(x, y, m_hIcon);
	}
	else
	{
		CDialogEx::OnPaint();
	}
}

//当用户拖动最小化窗口时系统调用此函数取得光标
//显示。
HCURSOR Chzhcn_getIPDlg::OnQueryDragIcon()
{
	return static_cast<HCURSOR>(m_hIcon);
}



void Chzhcn_getIPDlg::OnBnClickedOk()
{
	// TODO: 在此添加控件通知处理程序代码

	//CDialogEx::OnOK();
	g_txtIP.SetWindowText("");
	zhHttpGet("http://www.hanzhihong.cn/ip/getip.i.php?title=hzh_home",0,7,httpCallBack);
}


void Chzhcn_getIPDlg::OnBnClickedCancel()
{
	// TODO: 在此添加控件通知处理程序代码
	CDialogEx::OnCancel();
}


void Chzhcn_getIPDlg::dodododGIT(char*filename)
{
	char newip[128];
	char url[512];

	g_txtIP.GetWindowText(newip,512);
	if(0==strcmp(newip,""))
	{
		::MessageBox(0,"你木有获取到IP哟!!",0,0);
		return ;
	}

	char buf[512]={0};
	char *nnsddd=(char *)strrchr(filename,'/');
	if(nnsddd==NULL)
		nnsddd=(char *)strrchr(filename,'\\');

	if(nnsddd)
	{
		nnsddd++;
		if(0==strcmp(nnsddd,".git"))
		{
			sprintf_s(buf,"%s/config",filename);
		}
		else if(0==strcmp(nnsddd,"config"))
		{
			strcpy(buf,filename);
		}
		else
		{nnsddd=NULL;}
	}
	
	if(NULL==nnsddd)
	{
		if(filename[0]==0)
		{
			getCurrentPath(".git/config",buf,sizeof(buf));
		}
		else
		{
			char mmsg[512];
			sprintf_s(mmsg,"要拖入.git目录或者config文件!!\n\n%s",filename);
			::MessageBox(0,mmsg,0,0);
			return;
		}
	}

	if(0==access(buf,0))
	{
		GetPrivateProfileString("remote \"origin\"","url","",url,512,buf);
		TRACE("url=%s\n",url);
		char *pss=strchr(url,'@');
		if(pss)
		{
			pss++;
			char *ess=strchr(url,':');
			if(ess)
			{
				char newUrl[512]={0};
				char oip[128];
				*ess=0;
				strcpy(oip,pss);
				*ess=':';

				replace_str(url,oip,newip,newUrl);
				WritePrivateProfileString("remote \"origin\"","url",newUrl,buf);

				char mmsg[512];
				sprintf_s(mmsg,"(☆＿☆)干掉成功...\n\n%s",buf);
				::MessageBox(0,mmsg,"",0);
			}
		}
	}
	else
	{
		char mmsg[512];
		sprintf_s(mmsg,"没有找到文件哟!!\n\n%s",buf);
		::MessageBox(0,mmsg,0,0);
	}
}


void Chzhcn_getIPDlg::OnDropFiles(HDROP hDropInfo) 
{
//文件拖进来
UINT count;          
char filePath[512];            
count = DragQueryFile(hDropInfo, 0xFFFFFFFF, NULL, 0);          
if(count)           
{
for(UINT i=0; i<count; i++)                    
{
	int pathLen = DragQueryFile(hDropInfo, i, filePath, sizeof(filePath));                             
	//AfxMessageBox(filePath); 
	char bbbp[512];
	strcpy(bbbp,filePath);
	dodododGIT(bbbp);
}
}
DragFinish(hDropInfo); 
CDialog::OnDropFiles(hDropInfo);
}

void Chzhcn_getIPDlg::OnBnClickedButton1()
{
	// TODO: 在此添加控件通知处理程序代码
	dodododGIT("");
}
