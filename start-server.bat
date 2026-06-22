@echo off
title ASOIINFO Server - localhost:8000
echo ========================================
echo  ASOIINFO Platform - Development Server
echo  URL: http://localhost:8000
echo  Press Ctrl+C to stop
echo ========================================
SET PATH=C:\php;%PATH%
cd /d C:\asoiinfo-full
:loop
php artisan serve --host=0.0.0.0 --port=8000
echo Server stopped. Restarting in 2 seconds...
timeout /t 2 /nobreak >nul
goto loop
