#!/bin/sh

chgrp www-data database/database.sqlite
chmod g+w database/database.sqlite

chmod -R o+r public/
find public/ -type d -exec chmod o+x {} \;
setfacl -dR -m o::rx public/

chgrp www-data -R storage/
chmod -R g+w storage/
chmod -R u+w storage/
chmod -R o-w ./

find storage/ -type f -exec chmod u-x {} \;
find storage/ -type d -exec chmod u+x {} \;

find storage/ -type f -exec chmod g-x {} \;
find storage/ -type d -exec chmod g+x {} \;

find storage/ -type f -exec chmod g-s {} \;
find storage/ -type d -exec chmod g+s {} \;

setfacl -dR -m u::rwx storage/
setfacl -dR -m g::rwx storage/

chgrp www-data -R bootstrap/cache/
chmod -R g+w bootstrap/cache/
chmod -R u+w bootstrap/cache/
find bootstrap/cache/ -type f -exec chmod u-x {} \;
find bootstrap/cache/ -type d -exec chmod u+x {} \;
find bootstrap/cache/ -type f -exec chmod g-x {} \;
find bootstrap/cache/ -type d -exec chmod g+x {} \;
find bootstrap/cache/ -type f -exec chmod g-s {} \;
find bootstrap/cache/ -type d -exec chmod g+s {} \;
setfacl -dR -m u::rwx bootstrap/cache/
setfacl -dR -m g::rwx bootstrap/cache/

chgrp www-data -R storage/framework/cache/
chmod -R g+w storage/framework/cache/
chmod -R u+w storage/framework/cache/
find storage/framework/cache/ -type f -exec chmod u-x {} \;
find storage/framework/cache/ -type d -exec chmod u+x {} \;
find storage/framework/cache/ -type f -exec chmod g-x {} \;
find storage/framework/cache/ -type d -exec chmod g+x {} \;
find storage/framework/cache/ -type f -exec chmod g-s {} \;
find storage/framework/cache/ -type d -exec chmod g+s {} \;
setfacl -dR -m u::rwx storage/framework/cache/
setfacl -dR -m g::rwx storage/framework/cache/

chgrp testesdivertidos -R resources/views/unversioned/
chmod -R g+w resources/views/unversioned/
