@echo off

:: Set the repository URL
set repo_url=https://github.com/bhushan-Chavan03/quizzApp.git

:: Set the comment with system/PC name and current timestamp
for /f "tokens=2 delims==" %%I in ('wmic os get LocalDateTime /value') do set "dt=%%I"
set "comment=%COMPUTERNAME% %date:~10,4%-%date:~4,2%-%date:~7,2%_%time:~0,2%-%time:~3,2%-%time:~6,2%"

:: Navigate to the current directory where the batch file resides
cd /d "%~dp0"

:: Pull changes from the remote repository
git pull

:: Add all changes and commit with the generated comment
git add .
git commit -m "%comment%"

:: Push the changes to the remote repository
git push %repo_url%

:: Pause to view any potential error messages
pause
