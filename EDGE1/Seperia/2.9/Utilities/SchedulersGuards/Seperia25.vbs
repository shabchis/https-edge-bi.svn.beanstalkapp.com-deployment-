Dim objWMIService, colItems, objItem, strComputer, strFlashEXEFile
Dim count
 
strEXEFileName = "Edge.Applications.TempScheduler.exe"
strEXEFilePath = "D:\Edge\Seperia\2.5\Services\SeperiaScheduler_v25.exe" 
strComputer = "."
 
Set objWMIService = GetObject("winmgmts:\\" & strComputer & "\root\cimv2")
Set colItems = objWMIService.InstancesOf("Win32_Process")
 
count = 0
 
For Each objItem In colItems
    If objItem.Name = strEXEFileName Then
        count = count + 1
    Else
    End If
Next
 
Set objWMIService = Nothing
Set colItems = Nothing
 
If count = 0 Then
 
    Dim oShell
    Set oShell = WScript.CreateObject ("WScript.Shell")    
    Return = oShell.run(strEXEFilePath,3, false)
    Set oShell = Nothing
 
End If


