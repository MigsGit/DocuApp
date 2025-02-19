network:
  version: 2
  ethernets:
    eth0:
      dhcp4: no
      addresses: [192.168.1.100/24]  # Your static IP
      gateway4: 192.168.1.1
      nameservers:
        addresses:
          - 127.0.0.1
