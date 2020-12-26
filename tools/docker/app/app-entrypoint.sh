#!/usr/bin/env sh

set -e

role=""
env="production"
disable_config_cache="false"

[ -n "${CONTAINER_ROLE}" ] && role=${CONTAINER_ROLE}
[ -n "${APP_ENV}" ] && env=${APP_ENV}
[ -n "${DISABLE_ENTRYPOINT_CONFIG_CACHE}" ] && disable_config_cache=${DISABLE_ENTRYPOINT_CONFIG_CACHE}


# When we're root we want to use an unprivileged account
# but when we're in local dev we're probably using the same
# UID as the local user, so dont change that
currentid=$(id -u)
suexeccommand=""

if [ "$currentid" -eq "0" ]; then
    suexeccommand="su-exec www-data"
fi


if [ -z "${role}" ]; then
  cat <<EOM
[ERROR] You must define the CONTAINER_ROLE
        Valid roles are one of the following:
          - fpm
          - queue
          - scheduler-background-loop
          - artisan
EOM
  exit 1
fi

log() {
    echo "[${env}] $1"
}

log "Server is configured to be '${role}'"

#############################
# Run container based on role
#############################
if [ "$role" = "fpm" ]; then

    log "Passing off to php-fpm..."
    exec php-fpm

elif [ "$role" = "queue" ]; then

    log "Working the queue..."
    exec $suexeccommand php /var/www/app/artisan queue:work \
      --verbose \
      --tries=3 \
      --timeout=90

elif [ "$role" = "scheduler-background-loop" ]; then

    log "Loop de loop for scheduling..."
    while true; do
      $suexeccommand php /var/www/app/artisan schedule:run \
        --verbose \
        --no-interaction &
      sleep 60
    done

elif [ "$role" = "artisan" ]; then

    if [ -z "$ARTISAN_COMMAND" ]; then
        cat <<EOM
[ERROR] You must set the env var ARTISAN_COMMAND to a valid artisan command.
        If you're trying to run 'php artisan migrate:status --no-interaction'
        for example you'd set ARTISAN_COMMAND='migrate:status --no-interaction'
EOM

        exit 99;
    fi

    $suexeccommand php /var/www/app/artisan $ARTISAN_COMMAND

else

    log "Could not match the container role \"$role\""
    exit 1

fi
