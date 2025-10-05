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

## ToDO

- Punkte für Übungsergebnisse. (Pergamentrolle)

- vokabelliste als pdf drucken

- vokabel ändern

- vokabelliste  suchergebnisse auf mehrere seiten

- start button vokabelliste
- hinweis oder lösung bei quiz

