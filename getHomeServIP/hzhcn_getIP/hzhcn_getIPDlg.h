
// hzhcn_getIPDlg.h : 头文件
//

#pragma once
#include "afxwin.h"


// Chzhcn_getIPDlg 对话框
class Chzhcn_getIPDlg : public CDialogEx
{
// 构造
public:
	Chzhcn_getIPDlg(CWnd* pParent = NULL);	// 标准构造函数

// 对话框数据
	enum { IDD = IDD_HZHCN_GETIP_DIALOG };

	protected:
	virtual void DoDataExchange(CDataExchange* pDX);	// DDX/DDV 支持


// 实现
protected:
	HICON m_hIcon;

	// 生成的消息映射函数
	virtual BOOL OnInitDialog();
	afx_msg void OnPaint();
	afx_msg HCURSOR OnQueryDragIcon();
	DECLARE_MESSAGE_MAP()
public:
	afx_msg void OnBnClickedOk();
	afx_msg void OnBnClickedCancel();
	
	void dodododGIT(char*filename);

	afx_msg void OnDropFiles(HDROP hDropInfo); 
	afx_msg void OnBnClickedButton1();
};
