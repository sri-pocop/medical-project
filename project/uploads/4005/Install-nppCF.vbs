Dim CSI_IsSessionCache 'variable must be global to be persistent, otherwise 1 cmd window per call
strSQLiteURL = "http://sqlite.org/sqlite-dll-win32-x86-3070701.zip"
strnppCFURL = "http://www.nppcf.com/curver.txt"
bDebugMessagesOn = false
LeavePromptOpen = false   'change to True if your main script neends a console
DesiredScriptHost = "cscript.exe"    'change to cscript.exe if you main script needs a console
If bDebugMessagesOn Then LeavePromptOpen = False

'Detect if this script was relaunched to obtain admin rights
if wscript.arguments.count > 0 Then
  If wscript.arguments.named("r") = "RELAUNCHED" Then bRelaunched = True
End If

'These global objects used throughout all routines
Set oShell = CreateObject("WScript.Shell")
set oFSO = CreateObject("scripting.filesystemobject")
Dim SystemFolder: SystemFolder = oShell.ExpandEnvironmentStrings("%SystemRoot%") & "\System32"

If NOT bRelaunched Then  ' example of using relaunch detection to skip stuff

  If bDebugMessagesOn = True and DesiredScriptHost = "wscript.exe" Then msgbox "It is highly recommend that you switch to cscript.exe script host for debugging."

  'OpeningMessage = "This message will not appear on a relaunch." &vbnewline &vbnewline & _
  '"Anything that should not be done on a relaunch can be conditioned with bRelaunch"

  'UserMessage OpeningMessage
End If


'Determine Windows Version and prompt for admin rights if possible, without admin - abort
WinVer = oShell.RegRead("HKLM\SOFTWARE\Microsoft\Windows NT\CurrentVersion\CurrentVersion")
DebugMessage "Windows Version is " & WinVer
'Determine if Vista or Later - UAC Capable OS
If cint(oShell.RegRead("HKLM\SOFTWARE\Microsoft\Windows NT\CurrentVersion\CurrentVersion")) > 5 Then bUACPresent = True

' If we currently have admin rights - no need to elevate.
'   Uses CSI_IsAdmin which does not require whoami and therefore does not pop any CMD prompts
If NOT CSI_IsAdmin Then 'Checks for Admin on XP
  ' If we are running on a UAC capable OS, check if we are capable of elevating
  If bUACPresent Then
  'We have Vista or later, use passive detection of protected admin (unelevated admin)
    If CSI_IsSession("Admin") AND NOT CSI_IsSession("Elevated") Then
      'User is an administrator who is not elevated, prompt for elevation
      'Elevation prompting will NOT happen for non-admins because then
      'our install will put user profile files in the wrong profile
      DebugMessage "User is unelevated admin on Vista or later, elevating"
      'If Msgbox("You are a protected admin, do you wish to elevate this script?", _
      ' vbQuestion + vbYesNo, ScriptSeries & "Install Module") = vbYes Then
          LaunchScript DesiredScriptHost, True, LeavePromptOpen
      'Else
          'QUIT_ON_NO_NELEVATION If script should exit when elevation is denied, then uncomment the next line'
      '    wscript.quit
      'End If
    Elseif NOT CSI_IsSession("Admin") Then
      UserPrompt "You are not a protected administrator on this computer (this script can auto-elevate you if you are), aborting..."
      DebugMessage "Elevating using another user profile causes wrong profile to be used by installers - not supported."
      wscript.quit
    Else
      If NOT IsScriptHost(DesiredScriptHost) Then
      DebugMessage "Everything is OK, except we are not using the desired script host, relaunching."
      LaunchScript DesiredScriptHost, False, LeavePromptOpen
      End If
    End If
  Else
  ' We have XP or earlier
  ' Could push this through the relauncher (instead of aborting) to 
  '   get a prompt for admin credentials on XP'
    DebugMessage "User is non-admin on a pre-UAC OS, aborting"
    UserPrompt "You are not a local administrator on this computer, aborting..."
    wscript.quit
  End If
End If

If CSI_IsAdmin Then
  'UserMessage "We have admin!  Continuing..."
Else
  'UserMessage "We do not have admin!  Continuing..."
End If



'*******************************************************************
'*                     'MAINSCRIPTCODE GOES HERE'                  *
'*******************************************************************

strMessage = "Please ensure Notepad++ is closed before continuing." & vbcrlf & "Press the ENTER key to continue. "
Wscript.StdOut.Write strMessage

Do While Not WScript.StdIn.AtEndOfLine
   Input = WScript.StdIn.Read(1)
Loop


OsType = oShell.RegRead("HKLM\SYSTEM\CurrentControlSet\Control\Session Manager\Environment\PROCESSOR_ARCHITECTURE")
If OsType = "x86" then
	strProgramFiles = oShell.ExpandEnvironmentStrings("%PROGRAMFILES%")
elseif OsType = "AMD64" then
	strProgramFiles = oShell.ExpandEnvironmentStrings("%PROGRAMFILES(x86)%")
end if 
UserMessage "Checking Folders"
strNPPDir = strProgramFiles & "\Notepad++"
strNPPPluginsDir = strNPPDir & "\plugins"
strAppDatadir = oShell.ExpandEnvironmentStrings("%APPDATA%") & "\Notepad++\plugins\config"
if oFSO.FolderExists(strNPPDir) = False OR oFSO.FolderExists(strNPPPluginsDir) = False OR oFSO.FolderExists(strAppDatadir) = False Then
	UserPrompt "A Notepad++ Directory not found, Please install Manually, Exiting, Dirs are: " & vbcrlf & strNPPDir & vbcrlf & strNPPPluginsDir  & vbcrlf & strAppDatadir 
	wscript.quit
end if

oShell.CurrentDirectory = oFSO.GetParentFolderName(Wscript.ScriptFullName)

set sa = CreateObject("Shell.Application")
if oFSO.FileExists(strNPPDir & "\sqlite3.dll") = False Then
	' lets Grab SQLite
	UserMessage "Downloading SQLite"
	if DownloadFile(strSQLiteURL, oShell.CurrentDirectory & "\sqlite.zip") = False Then
		UserPrompt "SQLite download failed, Please install Manually, Exiting"
		wscript.quit
	End If
	
	UserMessage "Installing SQLite"
	set sqlliteFiles=sa.NameSpace(oShell.CurrentDirectory & "\sqlite.zip").items
	sa.NameSpace(strNPPDir).CopyHere(sqlliteFiles)
	oFSO.DeleteFile oShell.CurrentDirectory & "\sqlite.zip"
End if
UserMessage "Finding Current Version of nppColdFusion"
if DownloadFile(strnppCFURL, oShell.CurrentDirectory & "\curver.txt") = False Then
	UserPrompt "Can't find current version of nppColdFusion, Please install Manually, Exiting"
	wscript.quit
End If

Set oTextStream = oFSO.OpenTextFile(oShell.CurrentDirectory & "\curver.txt", 1)

strnppCFURL = oTextStream.ReadAll
oTextStream.Close
Set oTextStream = Nothing
oFSO.DeleteFile oShell.CurrentDirectory & "\curver.txt"
UserMessage "Downloading: " & strnppCFURL
if DownloadFile(strnppCFURL, oShell.CurrentDirectory & "\nppCF.zip") = False Then
	UserPrompt "Can't find current version of nppColdFusion, Please install Manually, Exiting"
	wscript.quit
End If
UserMessage "Installing nppColdFusion..."
set nppCFFiles=sa.NameSpace(oShell.CurrentDirectory & "\nppCF.zip").items
sa.NameSpace(oShell.CurrentDirectory).CopyHere(nppCFFiles)
if oFSO.FileExists(strNPPPluginsDir & "\nppColdFusion.dll") Then
	oFSO.DeleteFile strNPPPluginsDir & "\nppColdFusion.dll"
End If
if oFSO.FileExists(strAppDatadir & "\nppColdFusion.db3") Then
	oFSO.DeleteFile strAppDatadir & "\nppColdFusion.db3"
End If

if oFSO.FileExists(strAppDatadir & "\nppColdFusion.xml") Then
	oFSO.DeleteFile strAppDatadir & "\nppColdFusion.xml"
End If

oFSO.MoveFile oShell.CurrentDirectory & "\nppColdFusion.dll", strNPPPluginsDir & "\nppColdFusion.dll"
oFSO.MoveFile oShell.CurrentDirectory & "\config\nppColdFusion.db3", strAppDatadir & "\nppColdFusion.db3"
oFSO.MoveFile oShell.CurrentDirectory & "\config\nppColdFusion.xml", strAppDatadir & "\nppColdFusion.xml"
oFSO.DeleteFile oShell.CurrentDirectory & "\nppCF.zip"
oFSO.DeleteFile oShell.CurrentDirectory & "\INSTALL.txt"
wscript.echo "Finished installing nppColdFusion, closing window in 5 seconds."

wscript.sleep 5000
wscript.quit

Function IsScriptHost (CompareToHostName)
  DebugMessage "Desired: " & CompareToHostName _
  &vbnewline & "host: " & WScript.FullName
  IsScriptHost = False
  If lcase(mid(WScript.FullName, InstrRev(WScript.FullName,"\")+1)) = lcase(CompareToHostName) Then IsScriptHost = True
End Function

Sub LaunchScript (desiredhost, UACPromptIfNeeded, LeaveOpen)
  'automatically reopens in same working directory  (including drive letter)
  
  'We loose all network drives on a UAC elevation - block an attempt to elevate from one
  'Retaining drive letters can be configured (with associated security risks) see KB:
  ' http://support.microsoft.com/kb/937624.  This script detects if this policy is on'
  ' and allows network drive elevations to occur if it is.
  Dim oShell : Set oShell = CreateObject("WScript.Shell")
  Dim bLinkedConnectionsEnabled : bLinkedConnectionsEnabled = False
  On Error Resume Next
  Dim LinkedConnections : LinkedConnections = oShell.RegRead("HKLM\SOFTWARE\Microsoft\Windows\CurrentVersion\Policies\System\EnableLinkedConnections")
  If Err.Number < 1 and LinkedConnections > 0 Then bLinkedConnectionsEnabled = True
  On Error Goto 0
  
  if instr(1,wscript.scriptfullname,":",1) = 2 Then
    'Set drive = oFSO.GetDrive(oFSO.GetDriveName(wscript.scriptfullname))
    If oFSO.GetDrive(oFSO.GetDriveName(wscript.scriptfullname)).drivetype = 3 and NOT bLinkedConnectionsEnabled Then
      UserPrompt  "UAC limitation: Cannot elevate from a network drive letter." &vbnewline & _
      "Unless the LinkedConnections registry key is set.  For more" &vbnewline & _
      "information see http://support.microsoft.com/kb/937624"
      wscript.quit
    End If
  End If
  
  CMDOpenSwitch = " /c "
  If LeaveOpen = True Then CMDOpenSwitch = " /k "
  If UACPromptIfNeeded = True Then UACTrigger = "runas"
  'automatically use the same desired host if one was not passed
  If desiredhost = "" OR lcase(desiredhost) = "same" OR lcase(desiredhost) = "no change" Then desiredhost = lcase(mid(WScript.FullName, InstrRev(WScript.FullName,"\")+1))
  Set oFSO = CreateObject("Scripting.FileSystemObject")
  defaultdirectory = oFSO.GetAbsolutePathName(".")
  
  'set command prompt's current folder to match script.
  if oFSO.GetDriveName(".") <> oFSO.GetDriveName(oFSO.GetSpecialFolder(0)) Then
    switchdrive = oFSO.GetDriveName(oFSO.GetAbsolutePathName(".")) & " && CD " & oFSO.GetAbsolutePathName(".") & " && " 
  End If
  
             
  comspec = oShell.Environment("Process").Item("COMSPEC")
  DebugMessage "This script must be run in " & desiredhost & ", relaunching in new shell."
  're-launch script using the desired host
  Set oShell = CreateObject("WScript.Shell")
  Set objArgs = WScript.Arguments
  For I = 0 To objArgs.Count - 1
    args = args & " " & objArgs(I)
  Next
  
  args = args & " /R:RELAUNCHED"
  
  Set objShell = CreateObject("Shell.Application")
  DebugMessage "Relaunch Command: " & comspec & "," & CMDOpenSwitch & switchdrive & desiredhost & " """ & wscript.scriptfullname & """" & args & "," & defaultdirectory & "," & UACTrigger & "," & "1"
  objShell.ShellExecute comspec, CMDOpenSwitch & switchdrive & desiredhost & " """ & wscript.scriptfullname & """" & args, defaultdirectory, UACTrigger, 5
  
  'Do not remove the below quit or the original instance will continue to execute
  'Including handling UAC prompts that fail.
  WScript.Quit
End Sub

Function CSI_IsAdmin()
  'For information and updates see http://CSI-Windows.com/toolkit/csi-isadmin
  'For more comprehensive script see http://CSI-Windows.com/toolkit/csi-issession
 
  Dim oShell : Set oShell = createobject("wscript.shell")
  Dim oExec : Set oExec = oShell.Exec("%comspec% /c dir """ & oShell.RegRead("HKLM\SOFTWARE\Microsoft\Windows NT\CurrentVersion\ProfileList\S-1-5-18\ProfileImagePath") & """  2>&1 | findstr /I /C:""Not Found""")
  Do While oExec.Status = 0
    WScript.Sleep 100
  Loop
  If oExec.ExitCode <> 0 Then CSI_IsAdmin = True

End Function

Function UserMessage(MessageText)
 wscript.echo MessageText
End Function

Function UserPrompt(MessageText)
 msgbox MessageText
End Function

Function DebugMessage(MessageText)
  If bDebugMessagesOn Then wscript.echo "DEBUG MSG: " & MessageText
End Function

'CSI_IsSessionCache variable must be global to be persistent, otherwise 1 cmd window per call
Function CSI_IsSession (PermissionQueryString)
  'Much more usage info and sample checks for this function are available at
  'http://CSI-Windows.com/toolkit/CSI_IsSession
  'Can also check for any state detectable by any well known SID documented here:
  'http://CSI-Windows.com/toolkit/CSI_IsSession
  'Version 2.0
  CSI_IsSession = False  ' False unless proven otherwise
  Dim oShell : Set oShell = CreateObject("WScript.Shell")
  Dim oFSO : set oFSO = CreateObject("scripting.filesystemobject")
  Dim WinVer : WinVer = oShell.RegRead("HKLM\SOFTWARE\Microsoft\Windows NT\CurrentVersion\CurrentVersion")
  If WinVer >= 6 Then
    Dim UACSetting : UACSetting = oShell.RegRead("HKLM\Software\Microsoft\Windows\CurrentVersion\Policies\System\EnableLUA")
    Dim UACAdminSilentPrompt : UACAdminSilentPrompt = oShell.RegRead("HKLM\SOFTWARE\Microsoft\Windows\CurrentVersion\Policies\System\ConsentPromptBehaviorAdmin") 
  End If
  Dim ThisScriptFolder : ThisScriptFolder = oFSO.GetParentFoldername(wscript.scriptfullname)
  Dim whoamiexename : whoamiexename = "whoami.exe" 
  Dim ParseChar : ParseChar = "="
  Dim CheckFor, CmdToRun, Parts, CheckStatus
  Dim PermissionQuery, PermissionQueryList
  Dim oExec, bUsingExternalWhoami, bPreKernel6Whoami
  'Default whoami path in system32 - you could force this elsewhere if it makes sense
  Dim whoamipath : whoamipath = oShell.ExpandEnvironmentStrings("%SystemRoot%") & "\System32"
  
  'Find whoami.exe and determine whether older than version 6
  If NOT oFSO.FileExists(whoamipath & "\" & whoamiexename) Then
    If bDebugMessagesOn Then msgbox whoamipath & "\" & whoamiexename & " does not exist, checking next to script..."
    If NOT oFSO.FileExists(ThisScriptFolder & "\" & whoamiexename) Then
      wscript.echo "ERROR: cannot locate whoami.exe in system32 or script folder, aborting..."
      whoamipath = ""
      wscript.quit
    Else                                                              
      whoamipath = ThisScriptFolder
    End If 
  End If
  
  'Check for older version of whoami
  If cint(left(oFSO.GetFileVersion(whoamipath & "\" & whoamiexename),1)) <= 5 Then bPreKernel6Whoami = True
  
  If bDebugMessagesOn Then wscript.echo "whoami.exe Major version: " & cint(left(oFSO.GetFileVersion(whoamipath & "\" & whoamiexename),1))

  If bPreKernel6Whoami and bDebugMessagesOn Then wscript.echo "Using pre-version 6 whoami.exe"

  PermissionQueryList = split(PermissionQueryString,";")
  For Each PermissionQuery in PermissionQueryList
    If bDebugMessagesOn Then wscript.echo "PQueryString (before alias processing): " & PermissionQueryString &vbnewline & _
      "Current PQuery: " & PermissionQuery
 
  Select Case Ucase(PermissionQuery)
    'Setup aliases here
    Case "REFRESH_CACHE"             'grab whoami output again
      PermissionQuery =  "REFRESH_CACHE"
    Case "ADMIN"                     'whether or not elevated
      PermissionQuery =  "S-1-5-32-544"
    Case "ADMINISTRATOR"             'whether or not elevated
      PermissionQuery =  "S-1-5-32-544"
    Case "PROTECTED_ADMIN"             'Not elevated, but capable of elevating
      PermissionQuery =  "Administrators=deny"
    Case "ELEVATED_ADMIN"                  'elevation status
      PermissionQuery =  "S-1-16-12288"     ' uses high IL, should probably be used together
                                     ' with Admin to be 1000% reliable.  
                                     ' Like this CSI_IsSession("Admin;Elevated")
      If bPreKernel6Whoami Then PermissionQuery = "Administrators"
    Case "LOW_IL"
      PermissionQuery =  "S-1-16-4096"
    Case "MEDIUM_IL"
      PermissionQuery =  "S-1-16-8192"
    Case "HIGH_IL"
      PermissionQuery =  "S-1-16-12288"
    Case "SYSTEM_IL"
      PermissionQuery =  "S-1-16-16384"
    Case "LOCAL_SYSTEM"              'running under local system account
      PermissionQuery =  "S-1-5-18"
    Case "INTERACTIVE_SESSION"       'running on a desktop, not service or batch
      PermissionQuery =  "S-1-5-4"
    Case "NETWORK_SESSION"           'logged in over the network
      PermissionQuery =  "S-1-5-2"
    Case "REMOTE_SESSION"            'running via a remote login (terminal services, RDP)
      PermissionQuery =  "S-1-5-14"
    Case "SERVICE_SESSION"           'running under a service
      PermissionQuery =  "S-1-5-80"
    Case "DIALUP_SESSION"            'running via dial up session
      PermissionQuery =  "S-1-5-1"
    Case "DOMAIN_USER"               'Domain Administrator
      PermissionQuery =  "S-1-5-21*-513"
    Case "DOMAIN_ADMIN"              'Domain User
      PermissionQuery =  "S-1-5-21*-512"
    Case "ENTERPRISE_ADMIN"          'Enterprise Administrator
      PermissionQuery =  "S-1-5-21*-519"
    Case "DOMAIN_COMPUTER"           'Computer is joined to a domain
      PermissionQuery =  "S-1-5-21*-516"
    Case "DOMAIN_CONTROLLER"         'Computer is a domain CONTROLLER
      PermissionQuery =  "S-1-5-21*-515"
    Case "DOMAIN_RAS-IAS"            'Computer is a RAS or IAS server
      PermissionQuery =  "S-1-5-21*-553"  
    Case "UAC_DISABLED"                 'Cheating - was just easy to do
      If UACSetting = 0 Then CSI_IsSession = True
      If WinVer < 6 Then CSI_IsSession = False
      Exit Function
    Case "UAC_ENABLED"                 'Cheating - was just easy to do
      If UACSetting = 1 Then CSI_IsSession = True
      If WinVer < 6 Then CSI_IsSession = False
      Exit Function
    Case "UAC_SILENTADMINPROMPT"                 'Cheating - was just easy to do
      If UACAdminSilentPrompt = 0 Then CSI_IsSession = True
      If WinVer < 6 Then CSI_IsSession = False
      Exit Function
    Case "KERNEL6_CHECK"                 'Cheating - was just easy to do
      If Winver >= 6 Then CSI_IsSession = True 
      Exit Function
  End Select

  If bDebugMessagesOn Then wscript.echo "PQueryString (AFTER alias processing): " & PermissionQueryString &vbnewline & _
    "Current PQuery: " & PermissionQuery

  If Instr(1,PermissionQuery,ParseChar,1) > 0 Then 
    Parts = split(PermissionQuery,ParseChar)
    CheckFor = Parts(0)
    CheckStatus = Parts(1)
  Else
    CheckFor = PermissionQuery
  End If
  
  'transform special privilege enabled / disabled checks for XP version
  If bPreKernel6Whoami and CheckStatus = "Disabled" Then CheckStatus = "O"
  If bPreKernel6Whoami and CheckStatus = "Enabled" Then CheckStatus = "X"
  
  If IsEmpty(CSI_IsSessionCache) or Checkfor = "REFRESH_CACHE" Then

    CmdToRun = "%comspec% /c """ & whoamipath & "\" & whoamiexename & """ /all"
    Set oExec = oShell.Exec(CmdToRun)
    Do While oExec.Status = 0
      WScript.Sleep 1000
      'must terminate for when cscript.exe is used - whoami session won't return
      oExec.Terminate
    Loop
    CSI_IsSessionCache = oExec.StdOut.ReadAll
    if bDebugMessagesOn Then wscript.echo vbcrlf & "WHOAMI RAW RESULTS from this CMD: """ &vbcrlf & _
    cmdtorun & """" &vbcrlf &vbcrlf & CSI_IsSessionCache

    If Checkfor = "REFRESH_CACHE" Then 
      CSI_IsSession = True
      Exit Function
    End If
  End If

  If Checkfor = "DUMP_TO_TEMP" Then
    Dim tempname,tempfile
    tempname = oFSO.BuildPath(oFSO.GetSpecialFolder(2), oFSO.GetTempName) 
    tempname = Left(tempname,len(tempname)-4) & "-CSI_IsSessionWhoamiDump" & ".txt"
    Set tempfile = oFSO.CreateTextFile(tempname, True)
    If Err.Number > 0 Then Exit Function
    tempfile.write CSI_IsSessionCache 
    If Err.Number > 0 Then Exit Function
    tempfile.close
    If Err.Number > 0 Then Exit Function
    CSI_IsSession = True
    Exit Function
  End If

  
  Dim oReg, oMatches
  Set oReg = New RegExp
  oReg.IgnoreCase = True   
  
  oReg.Pattern = "\*"
  Checkfor = oReg.Replace(Checkfor, ".*")
  
  oReg.Pattern = "(.*"& Checkfor & "\W.*)"
  Set oMatches = oReg.Execute(CSI_IsSessionCache)
  If oMatches.count > 0 Then
    If CheckStatus = "" Then
      CSI_IsSession = True
    Else
      If Instr(1,Ucase(oMatches(0).value),Ucase(CheckStatus),1) > 0 Then
        CSI_IsSession = True
      Else
        CSI_IsSession = False
        Exit Function
      End If
    End If
    if bDebugMessagesOn Then wscript.echo "Query:             " & PermissionQuery &vbcrlf & _
    "Search Values:  " & Checkfor & "," & Checkstatus &vbcrlf & _
    "Result:             " & CSI_IsSession &vbcrlf &vbcrlf & _
    "Match Used: " &vbcrlf & vbcrlf & oMatches(0).value 
  Else
    if bDebugMessagesOn Then wscript.echo "Query: " & PermissionQuery &vbcrlf & _
    "Search Values: " & Checkfor & "," & Checkstatus &vbcrlf & _
    "Result: " & CSI_IsSession &vbcrlf &vbcrlf
    CSI_IsSession = False
    Exit Function 
  End If
Next

End Function


Function DownloadFile(url, saveas)
	strHDLocation = saveas
	' Fetch the file
	Set objXMLHTTP = CreateObject("MSXML2.XMLHTTP")
	
	objXMLHTTP.open "GET", url, false
	objXMLHTTP.send()

	If objXMLHTTP.Status = 200 Then
		Set objADOStream = CreateObject("ADODB.Stream")
		objADOStream.Open
		objADOStream.Type = 1 'adTypeBinary

		objADOStream.Write objXMLHTTP.ResponseBody
		objADOStream.Position = 0    'Set the stream position to the start

		Set objFSO = Createobject("Scripting.FileSystemObject")
		If objFSO.Fileexists(strHDLocation) Then objFSO.DeleteFile strHDLocation
		Set objFSO = Nothing

		objADOStream.SaveToFile strHDLocation
		objADOStream.Close
		Set objADOStream = Nothing
		Set objXMLHTTP = Nothing
		DownloadFile = true
		Exit Function
	End if

	Set objXMLHTTP = Nothing
	DownloadFile = False
End Function