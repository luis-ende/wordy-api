# Wordy API

Use `docker-compose` to run the app with `docker`, so you can run these commands:
```bash
cd [my-app-name]
docker-compose up -d
```
After that, open `http://localhost:8080` in your browser.

Open Sqlite database:

`docker exec -it wordy-api sqlite3 /var/www/db/wordy.db`