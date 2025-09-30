Book a place 

curl -X POST http://127.0.0.1:8000/api/bookings
    -H "Content-Type: application/json"
    -d '{"user_id":1,"bed":1,"starts_at":"2025-09-26T10:00:00","ends_at":"2025-09-26T11:30:00"}'

Liste of reservation

curl "http://127.0.0.1:8000/api/bookings?date=2025-09-26&bed=1"


Delete one reservation

curl -X DELETE http://127.0.0.1:8000/api/bookings/1
    -H "Content-Type: application/json"
    -d '{"user_id":1}'
