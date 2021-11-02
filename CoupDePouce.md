## Activité 2

### Requête SQL :
`select users.id as user_id, username, email, s.name as status from users join status s on users.status_id = s.id`
