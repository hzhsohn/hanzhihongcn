rem "���SDK����"

del "sdk\*.ncb"
del "sdk\*.suo" /a
del "sdk\*.sdf" /a
del "sdk\*.user"
rd "sdk\debug" /s/q
rd "sdk\Release" /s/q
rd "sdk\ipch" /s/q

rem "�������"
del "test\*.ncb"
del "test\*.aps"
del "test\*.suo" /a
del "test\*.sdf" /a
del "test\*.user"
rd "test\debug" /s/q
rd "test\Release" /s/q
rd "test\ipch" /s/q

rem "�����ѱ�����"

del "bin\debug\*.exp"
del "bin\debug\*.ilk"
del "bin\debug\*.pdb"

del "bin\release\*.exp"
del "bin\release\*.map"
del "bin\release\*.pdb"
del "bin\release\*.ilk"

rem cd ZhCTcp
rem start clean.bat