// Query database to bson
db.estates_baibai.find({'company_id': {$in: [161]}, 'removed': false}, {'_id': 1}).sort({_id: -1}).skip(50-1).limit(1);
mongodump --db fdk-dev --collection estates_baibai --out dump --query '{"_id":{$gte : ObjectId("5fdb47ce142bbd3fa3f81c82")}, "company_id": {$in: [161]}, "removed": false}'

// Import to database
mongorestore --db log_smart --drop --collection estates_baibai dump/fdk-dev/estates_baibai.bson

