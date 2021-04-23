// Query database to bson
db.estates_baibai.find({'company_id': {$in: [161]}, 'removed': false}, {'_id': 1}).sort({_id: -1}).skip(50-1).limit(1);
mongodump --db fdk-dev --collection estates_baibai --out dump --query '{"_id":{$gte : ObjectId("5fdb47ce142bbd3fa3f81c82")}, "company_id": {$in: [161]}, "removed": false}'
mongodump --db fdk-dev --collection estates_baibai --out dump --query '{"_id": {$in: [ObjectId("5fdb4a79eb7627403de73f59"), ObjectId("5ef321e20c9fd67101b8e332")]}}'

// Import to database
mongorestore --db log_smart --drop --collection estates_baibai dump/fdk-dev/estates_baibai.bson

// Export data json for test
mongoexport --host="localhost:27017" --collection=estates_baibai --db=fdk-dev --out=estate.json --query="{'_id': ObjectId('5f49f3ca417de704d35344b3')}"

