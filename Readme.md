# Vokabeltrainer

## Proxmox Container erstellen

```
CTID=120
pct create $CTID /var/lib/vz/template/cache/debian-12-standard_*.tar.zst \
  -hostname vokabel \
  -storage lvm_01 \
  -rootfs lvm_01:8 \
  -cores 2 -memory 1024 -swap 512 \
  -net0 name=eth0,bridge=vmbr0,ip=192.168.1.60/24,gw=192.168.1.1 \
  -nameserver 1.1.1.1 \
  -unprivileged 1 \
  -features keyctl=1,nesting=1 \
  -onboot 1
pct start $CTID
```

## Github

[Projektseite](https://github.com/guggenbergerME/Vokabeltrainer)

        git clone https://github.com/guggenbergerME/Vokabeltrainer.git

## Docker & Docker Compose install

```
apt update && apt upgrade -y
apt install apt-transport-https ca-certificates curl software-properties-common gnupg2 -y
curl -fsSL https://download.docker.com/linux/debian/gpg | apt-key add -
echo "deb [arch=amd64] https://download.docker.com/linux/debian $(lsb_release -cs) stable" | tee /etc/apt/sources.list.d/docker.list
apt update && apt install docker-ce -y
systemctl enable docker
curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose
docker-compose --version
```

## ToDO

- Punkte für Übungsergebnisse. (Pergamentrolle)

- vokabelliste als pdf drucken

- vokabel ändern

- vokabelliste  suchergebnisse auf mehrere seiten

- start button vokabelliste
- hinweis oder lösung bei quiz

