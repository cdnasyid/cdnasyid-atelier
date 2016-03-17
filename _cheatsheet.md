### rsync from MPB to MacPro

```shell
rsync -avzhu --progress --exclude 'backup-*' --exclude 'cdnasyid-atelier' --delete wan@wans-mbp.local:~/Sites/mamp-cdnasyid/* ~/Sites/mamp-cdnasyid
```
