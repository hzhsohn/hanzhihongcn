
// hzhcn_getIPDlg.h : ͷ�ļ�
//

#pragma once
#include "afxwin.h"


// Chzhcn_getIPDlg �Ի���
class Chzhcn_getIPDlg : public CDialogEx
{
// ����
public:
	Chzhcn_getIPDlg(CWnd* pParent = NULL);	// ��׼���캯��

// �Ի�������
	enum { IDD = IDD_HZHCN_GETIP_DIALOG };

	protected:
	virtual void DoDataExchange(CDataExchange* pDX);	// DDX/DDV ֧��


// ʵ��
protected:
	HICON m_hIcon;

	// ���ɵ���Ϣӳ�亯��
	virtual BOOL OnInitDialog();
	afx_msg void OnPaint();
	afx_msg HCURSOR OnQueryDragIcon();
	DECLARE_MESSAGE_MAP()
public:
	afx_msg void OnBnClickedOk();
	afx_msg void OnBnClickedCancel();
	
	afx_msg void OnBnClickedButton1();
};
