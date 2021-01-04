const db    = require('./db');

module.exports={
    
	getAllNews: (callback)=>{
		var sql="select * from news";
        db.getResults(sql, (results)=>{
			callback(results);
        });
	},


}