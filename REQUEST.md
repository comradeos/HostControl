### Get list of accounts
```bash
curl http://127.0.0.1:8080/api/accounts | jq
```

### Create a new account
```bash
curl -X POST http://127.0.0.1:8080/api/accounts \
-H "Content-Type: application/json" \
-d '{
  "email": "test@example.com",
  "full_name": "John Doe"
}' \
| jq
```

### Fail to create a new account
```bash
curl -X POST http://127.0.0.1:8080/api/accounts \
-H "Content-Type: application/json" \
-d '{
  "email": "invalid",
  "full_name": ""
}' \
| jq
```

### Get account by UUID
```bash
curl http://127.0.0.1:8080/api/accounts/019d4e02-b4ee-72f6-aafd-f3ef6a89b63b | jq
```

### Update account status
```bash
curl -X PATCH http://127.0.0.1:8080/api/accounts/019d4e02-b4ee-72f6-aafd-f3ef6a89b63b/status \
-H "Content-Type: application/json" \
-d '{
  "status": "deleted"
}' \
| jq
```


### Create hosting plan
```bash
curl -X POST http://127.0.0.1:8080/api/hosting-plans \
-H "Content-Type: application/json" \
-d '{
  "name": "Basic",
  "diskSpaceMb": 1024,
  "bandwidthMb": 10000,
  "price": 9.99
}' \
| jq
```

### Get list of hosting plans
```bash
curl http://127.0.0.1:8080/api/hosting-plans | jq
```


### 
```bash
```

