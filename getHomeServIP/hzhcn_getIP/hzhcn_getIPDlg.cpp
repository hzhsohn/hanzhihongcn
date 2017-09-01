
// hzhcn_getIPDlg.cpp : ʵ���ļ�
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


// Chzhcn_getIPDlg �Ի���
char*getCurrentPath(char*filename,char*dst_buf,int dst_buf_len)
{
  GetModuleFileNameA(NULL,dst_buf,dst_buf_len); 
  (strrchr(dst_buf, '\\'))[1] = 0; //ɾ���ļ�����ֻ���·��
 if(filename)
 { strcat_s(dst_buf,dst_buf_len,filename); }
 return dst_buf;
}

//����ֵ
//0=�滻ʧ��
//1=�滻�ɹ�
//replace_str(strSrc,"�ұ��滻��","����",strDst);
//���Ҳ��滻�ַ���
int replace_str(const char *pInput,const char *pSrc,const char *pDst,char *pOutput)
{
  const char   *pi;
  const char *p;
  int nSrcLen, nDstLen, nLen;
  int ret;
  ret=0;
  // ָ�������ַ������ζ�ָ��.
  pi = pInput;
  // ���㱻�滻�����滻���ĳ���.
  nSrcLen = (int)strlen(pSrc);
  nDstLen = (int)strlen(pDst);
  // ����piָ���ַ����е�һ�γ����滻����λ��,������ָ��(�Ҳ����򷵻�null).
  p = strstr(pi, pSrc);
  if(p)
  {
    char *po; // ָ������ַ������ζ�ָ��.
    po=(char*)malloc(strlen(pInput)+strlen(pDst)+1);
    // ���㱻�滻��ǰ���ַ����ĳ���.
    nLen = (int)(p - pi);
    // ���Ƶ�����ַ���.
    memcpy(po, pi, nLen);
    memcpy(po+nLen, pDst, nDstLen);
    strcpy(po+nLen+nDstLen, pi+nLen+nSrcLen);
    // ����ʣ���ַ���.
    strcpy(pOutput, po);
    free(po);
    po=NULL;
    ret=1;
  }
  else
  {
    // û���ҵ���ԭ������.
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


// Chzhcn_getIPDlg ��Ϣ�������

BOOL Chzhcn_getIPDlg::OnInitDialog()
{
	CDialogEx::OnInitDialog();

	// ���ô˶Ի����ͼ�ꡣ��Ӧ�ó��������ڲ��ǶԻ���ʱ����ܽ��Զ�
	//  ִ�д˲���
	SetIcon(m_hIcon, TRUE);			// ���ô�ͼ��
	SetIcon(m_hIcon, FALSE);		// ����Сͼ��

	// TODO: �ڴ���Ӷ���ĳ�ʼ������
	OnBnClickedOk();

	return TRUE;  // ���ǽ��������õ��ؼ������򷵻� TRUE
}

// �����Ի��������С����ť������Ҫ����Ĵ���
//  �����Ƹ�ͼ�ꡣ����ʹ���ĵ�/��ͼģ�͵� MFC Ӧ�ó���
//  �⽫�ɿ���Զ���ɡ�

void Chzhcn_getIPDlg::OnPaint()
{
	if (IsIconic())
	{
		CPaintDC dc(this); // ���ڻ��Ƶ��豸������

		SendMessage(WM_ICONERASEBKGND, reinterpret_cast<WPARAM>(dc.GetSafeHdc()), 0);

		// ʹͼ���ڹ����������о���
		int cxIcon = GetSystemMetrics(SM_CXICON);
		int cyIcon = GetSystemMetrics(SM_CYICON);
		CRect rect;
		GetClientRect(&rect);
		int x = (rect.Width() - cxIcon + 1) / 2;
		int y = (rect.Height() - cyIcon + 1) / 2;

		// ����ͼ��
		dc.DrawIcon(x, y, m_hIcon);
	}
	else
	{
		CDialogEx::OnPaint();
	}
}

//���û��϶���С������ʱϵͳ���ô˺���ȡ�ù��
//��ʾ��
HCURSOR Chzhcn_getIPDlg::OnQueryDragIcon()
{
	return static_cast<HCURSOR>(m_hIcon);
}



void Chzhcn_getIPDlg::OnBnClickedOk()
{
	// TODO: �ڴ���ӿؼ�֪ͨ����������

	//CDialogEx::OnOK();
	g_txtIP.SetWindowText("");
	zhHttpGet("http://www.hanzhihong.cn/ip/getip.i.php?title=hzh_home",0,7,httpCallBack);
}


void Chzhcn_getIPDlg::OnBnClickedCancel()
{
	// TODO: �ڴ���ӿؼ�֪ͨ����������
	CDialogEx::OnCancel();
}


void Chzhcn_getIPDlg::dodododGIT(char*filename)
{
	char newip[128];
	char url[512];

	g_txtIP.GetWindowText(newip,512);
	if(0==strcmp(newip,""))
	{
		::MessageBox(0,"��ľ�л�ȡ��IPӴ!!",0,0);
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
			sprintf_s(mmsg,"Ҫ����.gitĿ¼����config�ļ�!!\n\n%s",filename);
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
				sprintf_s(mmsg,"(��ߡ�)�ɵ��ɹ�...\n\n%s",buf);
				::MessageBox(0,mmsg,"",0);
			}
		}
	}
	else
	{
		char mmsg[512];
		sprintf_s(mmsg,"û���ҵ��ļ�Ӵ!!\n\n%s",buf);
		::MessageBox(0,mmsg,0,0);
	}
}


void Chzhcn_getIPDlg::OnDropFiles(HDROP hDropInfo) 
{
//�ļ��Ͻ���
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
	// TODO: �ڴ���ӿؼ�֪ͨ����������
	dodododGIT("");
}
