#!/bin/sh

install_kima() {
    mkdir -p /var/www/html
    echo
    echo "Construyendo Kima..."
    podman build -t kimaimage .
    echo
    echo "Iniciando Kima..."
    podman run -d --name Kima -v /var/www/html:/var/www/html --network host kimaimage
    cp -rf ./. /var/www/html
    rm -f /var/www/html/Dockerfile
    rm -f /var/www/html/install.sh
    echo
    echo "Kima está corriendo en el puerto 8080"
    echo "El codigo de Kima está expuesto en /var/www/html"
}

install_sql() {
    echo
    echo "Ingrese contraseña para el usuario SA en SQL Server (mayuscula, numero y caracter especial OBLIGATORIOS):"
    read SA_PASSWORD
    echo
    echo "Iniciando SQL Server..."
    podman run -e "ACCEPT_EULA=Y" -e "MSSQL_SA_PASSWORD=$SA_PASSWORD" -e "MSSQL_PID=Express" -d --name SQLServer --network host mcr.microsoft.com/mssql/server:2019-latest 
    echo
    echo "SQLServer está corriendo en el puerto 1433"
}

install_systemd() {
    echo
    echo "Activando servicio de Systemd"
    
    podman generate systemd --name Kima --files --restart-policy=always
    podman generate systemd --name SQLServer --files --restart-policy=always    

    mv container-Kima.service /etc/systemd/system/
    mv container-SQLServer.service /etc/systemd/system/

    systemctl daemon-reload
    systemctl enable container-Kima.service
    systemctl enable container-SQLServer.service
}

install_tooling() {
    echo
    echo "Instalando actualizador de Kima"
    ALIAS_LINE = "alias kima-update='cd /var/www/html && git pull'"

    if ! grep -Fxq "$ALIAS_LINE" /root/.bashrc; then
        echo "$ALIAS_LINE" >> /root/.bashrc

    echo
    echo "Actualizador instalado exitosamente"
}

if [[ $EUID -ne 0 ]]; then
  echo "ERROR: Necesitas correr este script como root (sudo)."
  exit 1
fi

if ! which podman &> /dev/null; then
  echo "ERROR: Podman no está instalado."
  exit 1
fi

echo "Script de Instalación de Kima!"
echo
echo " _  ___                 "
echo "| |/ (_)                "
echo "| ' / _ _ __ ___   __ _ "
echo "|  < | | '_ \ _ \ / _\ |"
echo "| . \| | | | | | | (_| |"
echo "|_|\_\_|_| |_| |_|\__,_|"

install_kima
install_sql
install_systemd
install_tooling

echo
echo "\nTodo ok!"
echo
echo "|\---/|"
echo "| o_o |"
echo " \_^_/ "
echo