
// hzhcn_getIP.h : PROJECT_NAME Ӧ�ó������ͷ�ļ�
//

#pragma once

#ifndef __AFXWIN_H__
	#error "�ڰ������ļ�֮ǰ������stdafx.h�������� PCH �ļ�"
#endif

#include "resource.h"		// ������


// Chzhcn_getIPApp:
// �йش����ʵ�֣������ hzhcn_getIP.cpp
//

class Chzhcn_getIPApp : public CWinApp
{
public:
	Chzhcn_getIPApp();

// ��д
public:
	virtual BOOL InitInstance();

// ʵ��

	DECLARE_MESSAGE_MAP()
};

extern Chzhcn_getIPApp theApp;