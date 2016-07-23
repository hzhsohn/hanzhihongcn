#include "stdafx.h"
#include "stdio.h"
#include "tchar.h"
#include "main2.h"

//定义全局函数
void Init();
BOOL IsInstalled();
BOOL Install();
BOOL Uninstall();
void LogEvent(LPCTSTR pszFormat, ...);

//这三个函数可用于操作服务
BOOL ServiceStart();
BOOL ServiceStop();
DWORD ServiceState();

//回调函数
void WINAPI ServiceMain();
void WINAPI ServiceStrl(DWORD dwOpcode);


//安装的程序服务名字
#define AUTO_STARTUP	1
TCHAR szServiceName[] = _T("han.zh web chat service");
BOOL bInstall;
SERVICE_STATUS_HANDLE hServiceStatus;
SERVICE_STATUS status;


int main(int argc,char *argv[]) 
{
	char lpCmdLine[32];
	memset(lpCmdLine,0,sizeof(lpCmdLine));
	if(argc>1)
	{
		strcpy(lpCmdLine,argv[1]);
	}

	if(stricmp(lpCmdLine, "") == 0)
	{
		printf("--------------------------------------------\r\n");
		printf("used parameter:\r\n");
		printf("  -run           direct running the procedure\r\n");
		printf("  -install       install windows service \r\n");
		printf("  -start         startup service\r\n");
		printf("  -stop          stop service\r\n");
		printf("  -status        output service status\r\n");
		printf("  -uninstall     uninstall service\r\n");
		printf("  -help          output help document\r\n");
		printf("--------------------------------------------\r\n");
	}

	//开始处理
	Init();

    SERVICE_TABLE_ENTRY st[] =
    {
        { szServiceName, (LPSERVICE_MAIN_FUNCTION)ServiceMain },
        { NULL, NULL }
    };

	if (stricmp(lpCmdLine, "/run") == 0 ||
		stricmp(lpCmdLine, "-run") == 0 ||
		stricmp(lpCmdLine, "run") == 0)
	{
		//如果参数为run即直接运行操作
		//开始程序
		main2();
	}
	else if (stricmp(lpCmdLine, "/help") == 0 ||
		stricmp(lpCmdLine, "-help") == 0 ||
		stricmp(lpCmdLine, "help") == 0 ||
		stricmp(lpCmdLine, "/?") == 0 ||
		stricmp(lpCmdLine, "-?") == 0 ||
		stricmp(lpCmdLine, "?") == 0)
	{
		printf("--------------------------------------------\r\n");
		printf("used parameter:\r\n");
		printf("  -run           direct running the procedure\r\n");
		printf("  -install       install windows service \r\n");
		printf("  -start         startup service\r\n");
		printf("  -stop          stop service\r\n");
		printf("  -status        output service status\r\n");
		printf("  -uninstall     uninstall service\r\n");
		printf("  -help          output help document\r\n");

	}
	else if (stricmp(lpCmdLine, "/install") == 0 ||
		stricmp(lpCmdLine, "-install") == 0 ||
		stricmp(lpCmdLine, "install") == 0)
	{
		if(Install())
		{
			_tprintf(_T("\"%s\" install successfully.\r\n"),szServiceName);
#if AUTO_STARTUP
			if(ServiceStart())
			{_tprintf(_T("service \"%s\" start ok.\r\n"),szServiceName);}
			else
			{_tprintf(_T("service \"%s\" start fail.\r\n"),szServiceName);}
#endif // AUTO_STARTUP
		}
		else{_tprintf(_T("\"%s\" install unsuccessful.\r\n"),szServiceName);}
	}
	else if (stricmp(lpCmdLine, "/uninstall") == 0 ||
			stricmp(lpCmdLine, "-uninstall") == 0 ||
			stricmp(lpCmdLine, "uninstall") == 0)
	{
		if(Uninstall())
		{_tprintf(_T("service \"%s\" uninstall ok.\r\n"),szServiceName);}
		else{_tprintf(_T("service \"%s\" uninstall fail.\r\n"),szServiceName);}
	}
	else if (stricmp(lpCmdLine, "/start") == 0 ||
			stricmp(lpCmdLine, "-start") == 0 ||
			stricmp(lpCmdLine, "start") == 0)
	{
		if(ServiceStart())
		{_tprintf(_T("service \"%s\" start ok.\r\n"),szServiceName);}
		else
		{_tprintf(_T("service \"%s\" start fail.\r\n"),szServiceName);}
	}
	else if (stricmp(lpCmdLine, "/stop") == 0 ||
			stricmp(lpCmdLine, "-stop") == 0 ||
			stricmp(lpCmdLine, "stop") == 0)
	{
		if(ServiceStop())
		{_tprintf(_T("service \"%s\" already stop.\r\n"),szServiceName);}
		else{_tprintf(_T("service \"%s\" operate fail.\r\n"),szServiceName);}
	}
	else if (stricmp(lpCmdLine, "/status") == 0 ||
			stricmp(lpCmdLine, "-status") == 0 ||
			stricmp(lpCmdLine, "status") == 0)
	{
		DWORD dw=ServiceState();
		TCHAR *str;
		switch(dw)
		{
		case SERVICE_STOPPED:
			str=_T("SERVICE_STOPPED");
			break;
		case SERVICE_START_PENDING:
			str=_T("SERVICE_START_PENDING");
			break;
		case SERVICE_STOP_PENDING:
			str=_T("SERVICE_STOP_PENDING");
			break;
		case SERVICE_RUNNING:
			str=_T("SERVICE_RUNNING");
			break;
		case SERVICE_CONTINUE_PENDING:
			str=_T("SERVICE_CONTINUE_PENDING");
			break;
		case SERVICE_PAUSE_PENDING:
			str=_T("SERVICE_PAUSE_PENDING");
			break;
		case SERVICE_PAUSED:
			str=_T("SERVICE_PAUSED");
			break;
		default:
			str=_T("SERVICE_NOT_FOUND");
			break;
		}
		_tprintf(_T("service \"%s\" state is %d:%s\r\n"),szServiceName,dw,str);
	}
	else
	{
		if (!StartServiceCtrlDispatcher(st))
		{
			LogEvent(_T("Register Service Main Function Error!"));
		}
	}

	return 0;
}
//*********************************************************
//Functiopn:			Init
//Description:			初始化
//Calls:				main
//Called By:				
//Table Accessed:				
//Table Updated:
//Input:				
//Output:				
//Return:
//Others:				
//History:
//*********************************************************
void Init()
{
    hServiceStatus = NULL;
    status.dwServiceType = SERVICE_WIN32_OWN_PROCESS;
    status.dwCurrentState = SERVICE_STOPPED;
    status.dwControlsAccepted = SERVICE_ACCEPT_STOP;
    status.dwWin32ExitCode = 0;
    status.dwServiceSpecificExitCode = 0;
    status.dwCheckPoint = 0;
    status.dwWaitHint = 0;
}

//*********************************************************
//Functiopn:			IsInstalled
//Description:			判断服务是否已经被安装
//Calls:
//Called By:
//Table Accessed:
//Table Updated:
//Input:
//Output:
//Return:
//Others:
//History:
//*********************************************************
BOOL IsInstalled()
{
    BOOL bResult = FALSE;

	//打开服务控制管理器
    SC_HANDLE hSCM = ::OpenSCManager(NULL, NULL, SC_MANAGER_ALL_ACCESS);

    if (hSCM != NULL)
    {
		//打开服务
        SC_HANDLE hService = ::OpenService(hSCM, szServiceName, SERVICE_QUERY_CONFIG);
        if (hService != NULL)
        {
            bResult = TRUE;
            ::CloseServiceHandle(hService);
        }
        ::CloseServiceHandle(hSCM);
    }
    return bResult;
}

//*********************************************************
//Functiopn:			Install
//Description:			安装服务函数
//Calls:
//Called By:
//Table Accessed:
//Table Updated:
//Input:
//Output:
//Return:
//Others:
//History:
//*********************************************************
BOOL Install()
{
    if (IsInstalled())
        return TRUE;

	//打开服务控制管理器
    SC_HANDLE hSCM = ::OpenSCManager(NULL, NULL, SC_MANAGER_ALL_ACCESS);
    if (hSCM == NULL)
    {
		_tprintf(_T("Couldn't open service \"%s\" manager\r\n"), szServiceName);
        return FALSE;
    }

    // Get the executable file path
    TCHAR szFilePath[MAX_PATH];
    ::GetModuleFileName(NULL, szFilePath, MAX_PATH);

	//创建服务
    SC_HANDLE hService = ::CreateService(
        hSCM, szServiceName, szServiceName,
        SERVICE_ALL_ACCESS, SERVICE_WIN32_OWN_PROCESS,
#if AUTO_STARTUP
			SERVICE_AUTO_START, //以自动方式开始
#else
			SERVICE_DEMAND_START, //是手动启动
#endif // AUTO_STARTUP
		SERVICE_ERROR_NORMAL,
        szFilePath, NULL, NULL, _T(""), NULL, NULL);

    if (hService == NULL)
    {
        ::CloseServiceHandle(hSCM);
        _tprintf(_T("Couldn't create service \"%s\"\r\n"), szServiceName);
        return FALSE;
    }

    ::CloseServiceHandle(hService);
    ::CloseServiceHandle(hSCM);
    return TRUE;
}

//*********************************************************
//Functiopn:			Uninstall
//Description:			删除服务函数
//Calls:
//Called By:
//Table Accessed:
//Table Updated:
//Input:
//Output:
//Return:
//Others:
//History:
//*********************************************************
BOOL Uninstall()
{
    if (!IsInstalled())
        return FALSE;

    SC_HANDLE hSCM = ::OpenSCManager(NULL, NULL, SC_MANAGER_ALL_ACCESS);

    if (hSCM == NULL)
    {
        _tprintf(_T("Couldn't open service \"%s\" manager\r\n"), szServiceName);
        return FALSE;
    }

    SC_HANDLE hService = ::OpenService(hSCM, szServiceName, SERVICE_STOP | DELETE);

    if (hService == NULL)
    {
        ::CloseServiceHandle(hSCM);
        _tprintf(_T("Couldn't open service \"%s\" manager\r\n"), szServiceName);
        return FALSE;
    }
    SERVICE_STATUS status;
    ::ControlService(hService, SERVICE_CONTROL_STOP, &status);

	//删除服务
    BOOL bDelete = ::DeleteService(hService);
    ::CloseServiceHandle(hService);
    ::CloseServiceHandle(hSCM);

    if (bDelete)
        return TRUE;

    LogEvent(_T("Service could not be deleted"));
    return FALSE;
}

//*********************************************************
//Functiopn:			LogEvent
//Description:			记录服务事件
//Calls:
//Called By:
//Table Accessed:
//Table Updated:
//Input:
//Output:
//Return:
//Others:
//History:
//*********************************************************
void LogEvent(LPCTSTR pFormat, ...)
{
    TCHAR   chMsg[256];
    HANDLE  hEventSource;
    LPTSTR  lpszStrings[1];
    va_list pArg;

    va_start(pArg, pFormat);
    _vstprintf(chMsg, pFormat, pArg);
    va_end(pArg);

    lpszStrings[0] = chMsg;
	
	hEventSource = RegisterEventSource(NULL, szServiceName);
	if (hEventSource != NULL)
	{
		ReportEvent(hEventSource, EVENTLOG_INFORMATION_TYPE, 0, 0, NULL, 1, 0, (LPCTSTR*) &lpszStrings[0], NULL);
		DeregisterEventSource(hEventSource);
	}
}


//*********************************************************
//Function
//启用服务
//*********************************************************
BOOL ServiceStart()
{
   // 打开服务管理对象
    SC_HANDLE hSC = OpenSCManager( NULL, 
                        NULL, GENERIC_EXECUTE);
    if( hSC == NULL)
    {
        LogEvent(_T("open SCManager error"));
        return FALSE;
    }
    // 打开服务szServiceName
    SC_HANDLE hSvc = OpenService( hSC, szServiceName,
        SERVICE_START | SERVICE_QUERY_STATUS | SERVICE_STOP);
    if( hSvc == NULL)
    {
        LogEvent(_T("Open service erron."));
        CloseServiceHandle( hSC);
        return FALSE;
    }
    // 获得服务的状态
    SERVICE_STATUS status;
    if( QueryServiceStatus( hSvc, &status) == FALSE)
    {
        LogEvent(_T("Get Service state error。"));
        CloseServiceHandle( hSvc);
        CloseServiceHandle( hSC);
        return FALSE;
    }
    
	if( status.dwCurrentState == SERVICE_STOPPED)
    {
        // 启动服务
        if( StartService( hSvc, NULL, NULL) == FALSE)
        {
            LogEvent(_T("start service error."));
            CloseServiceHandle( hSvc);
            CloseServiceHandle( hSC);
            return FALSE;
        }
        // 等待服务启动
        while( QueryServiceStatus( hSvc, &status) == TRUE)
        {
            Sleep( status.dwWaitHint);
            if( status.dwCurrentState == SERVICE_RUNNING)
            {
                break;
            }
      }
    }
    CloseServiceHandle( hSvc);
    CloseServiceHandle( hSC);
	return TRUE;
}


//*********************************************************
//Function
//关闭服务
//*********************************************************
BOOL ServiceStop()
{
   // 打开服务管理对象
    SC_HANDLE hSC = ::OpenSCManager( NULL, 
                        NULL, GENERIC_EXECUTE);
    if( hSC == NULL)
    {
        LogEvent(_T("open SCManager error"));
        return FALSE;
    }
    // 打开服务szServiceName
    SC_HANDLE hSvc = ::OpenService( hSC, szServiceName,
        SERVICE_START | SERVICE_QUERY_STATUS | SERVICE_STOP);
    if( hSvc == NULL)
    {
        LogEvent(_T("Open service erron."));
        CloseServiceHandle( hSC);
        return FALSE;
    }
    // 获得服务的状态
    SERVICE_STATUS status;
    if( QueryServiceStatus( hSvc, &status) == FALSE)
    {
        LogEvent(_T("Get Service state error。"));
        CloseServiceHandle( hSvc);
        CloseServiceHandle( hSC);
        return FALSE;
    }
    //如果处于停止状态则启动服务，否则停止服务。
    if( status.dwCurrentState == SERVICE_RUNNING)
    {
        // 停止服务
        if( ControlService( hSvc, 
          SERVICE_CONTROL_STOP, &status) == FALSE)
        {
            //LogEvent( "stop service error.");
            CloseServiceHandle( hSvc);
            CloseServiceHandle( hSC);
            return FALSE;
        }
        // 等待服务停止
        while( QueryServiceStatus( hSvc, &status) == TRUE)
        {
            Sleep( status.dwWaitHint);
            if( status.dwCurrentState == SERVICE_STOPPED)
            {
                break;
            }
        }
    }
    
    CloseServiceHandle( hSvc);
    CloseServiceHandle( hSC);
	return TRUE;
}

//*********************************************************
//Function
//查询服务状态
//return
// error								  0
// SERVICE_STOPPED                        0x00000001
// SERVICE_START_PENDING                  0x00000002
// SERVICE_STOP_PENDING                   0x00000003
// SERVICE_RUNNING                        0x00000004
// SERVICE_CONTINUE_PENDING               0x00000005
// SERVICE_PAUSE_PENDING                  0x00000006
// SERVICE_PAUSED                         0x00000007

//*********************************************************
DWORD ServiceState()
{
	DWORD ret=0;

    // 打开服务管理对象
    SC_HANDLE hSC = ::OpenSCManager( NULL, 
                        NULL, GENERIC_EXECUTE);
    if( hSC == NULL)
    {
        LogEvent(_T("open SCManager error"));
        return 0;
    }
    // 打开服务szServiceName
    SC_HANDLE hSvc = ::OpenService( hSC, szServiceName,
        SERVICE_START | SERVICE_QUERY_STATUS | SERVICE_STOP);
    if( hSvc == NULL)
    {
        LogEvent(_T("Open service erron."));
        CloseServiceHandle( hSC);
        return 0;
    }
    // 获得服务的状态
    SERVICE_STATUS status;
    if( QueryServiceStatus( hSvc, &status) == FALSE)
    {
        LogEvent(_T("Get Service state error。"));
        CloseServiceHandle( hSvc);
        CloseServiceHandle( hSC);
        ret= 0;
    }
	ret=status.dwCurrentState;
    
    CloseServiceHandle( hSvc);
    CloseServiceHandle( hSC);
	return ret;
}


//*********************************************************
//Functiopn:			ServiceMain
//Description:			服务主函数，这在里进行控制对服务控制的注册
//Calls:
//Called By:
//Table Accessed:
//Table Updated:
//Input:
//Output:
//Return:
//Others:
//History:
//*********************************************************
void WINAPI ServiceMain()
{
    // Register the control request handler
    status.dwCurrentState = SERVICE_START_PENDING;
	status.dwControlsAccepted = SERVICE_ACCEPT_STOP;

	//注册服务控制
    hServiceStatus = RegisterServiceCtrlHandler(szServiceName, ServiceStrl);
    if (hServiceStatus == NULL)
    {
        LogEvent(_T("Handler not installed"));
        return;
    }
    SetServiceStatus(hServiceStatus, &status);

    status.dwWin32ExitCode = S_OK;
    status.dwCheckPoint = 0;
    status.dwWaitHint = 0;
	status.dwCurrentState = SERVICE_RUNNING;
	SetServiceStatus(hServiceStatus, &status);

	//--------------------------------------------------------------
	//服务。应用时将主要任务放于此即可
	main_init2();
	while (SERVICE_RUNNING==status.dwCurrentState)
	{
		main_loop2(); 
		Sleep(1);
	}
	main_destory2();
	//--------------------------------------------------------------

    status.dwCurrentState = SERVICE_STOPPED;
    SetServiceStatus(hServiceStatus, &status);
    LogEvent(_T("Service stopped"));
}

//*********************************************************
//Functiopn:			ServiceStrl
//Description:			服务控制主函数，这里实现对服务的控制，
//						当在服务管理器上停止或其它操作时，将会运行此处代码
//Calls:
//Called By:
//Table Accessed:
//Table Updated:
//Input:				dwOpcode：控制服务的状态
//Output:
//Return:
//Others:
//History:
//*********************************************************
void WINAPI ServiceStrl(DWORD dwOpcode)
{
    switch (dwOpcode)
    {
    case SERVICE_CONTROL_STOP:
		status.dwCurrentState = SERVICE_STOP_PENDING;
        SetServiceStatus(hServiceStatus, &status);
		//一定要关闭程序才能完整关闭服务,上面是用
        break;
    case SERVICE_CONTROL_PAUSE:
        break;
    case SERVICE_CONTROL_CONTINUE:
        break;
    case SERVICE_CONTROL_INTERROGATE:
        break;
    case SERVICE_CONTROL_SHUTDOWN:
        break;
    default:
        LogEvent(_T("Bad service request"));
		break;
    }
}