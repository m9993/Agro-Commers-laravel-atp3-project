const express 	                    = require('express');
const router 	                    = express.Router();
const customerModel                 = require.main.require('./models/customerModel');



router.get('/', (req, res)=>{
    customerModel.getAllNews((results)=>{
        // console.log(results);
        res.json(results);
    });
});



module.exports = router;

