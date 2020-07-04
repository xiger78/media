#!/bin/sh

############################
# user id : pi
# transmission passwod : raspberry
#
#example)
# pi:raspberry
############################

#Change directory access authority
sudo chmod 777 -R /mnt/sda1

#Change directory owning group
sudo chgrp -R pi /mnt/sda1/Downloads

#Change directory owner
sudo chown -R pi /mnt/sda1/Downloads

SERVER="9091"

TORRENTLIST=`transmission-remote $SERVER -n pi:raspberry --list | sed -e '1d;$d;s/^ *//' | cut --only-delimited --delimiter=" " --fields=1`
for TORRENTID in $TORRENTLIST
do
    DL_COMPLETED=`transmission-remote $SERVER -n pi:raspberry --torrent $TORRENTID --info | grep "Percent Done: 100%"`
    FILE_NAME=`transmission-remote $SERVER -n pi:raspberry --torrent $TORRENTID --info | grep "Name:"`
    MAG_NET=`transmission-remote $SERVER -n pi:raspberry --torrent $TORRENTID --info | grep "Magnet:"`
    FILE_SIZE=`transmission-remote $SERVER -n pi:raspberry --torrent $TORRENTID --info | grep "Have:"`
    STATE_STOPPED=`transmission-remote $SERVER -n pi:raspberry --torrent $TORRENTID --info | grep "State: Seeding\|Stopped\|Finished\|Idle"`
    if [ "$DL_COMPLETED" ] && [ "$STATE_STOPPED" ]; then
        python /home/pi/autosend.py "$FILE_NAME" "$MAG_NET" "$FILE_SIZE"
        transmission-remote $SERVER -n pi:pi --torrent $TORRENTID --remove
    fi
done
