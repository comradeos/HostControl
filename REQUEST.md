### Get list of accounts
```bash
curl http://127.0.0.1:8080/api/accounts
```

### Create a new account
```bash
curl -X POST http://127.0.0.1:8080/api/accounts \
-H "Content-Type: application/json" \
-d '{ "email":"kolka@gmail.com", "full_name": "Kolka"}'
```