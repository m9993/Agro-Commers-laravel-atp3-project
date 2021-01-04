//declaration
const express 						= require('express');	

// const login							= require('./controllers/login');
const customer						= require('./controllers/customer');


const app							= express();
const port							= 1000;

//configuration
// app.set('view engine', 'ejs');


//middleware


// app.use('/', login);
// app.use('/login', login);
app.use('/customer/news', customer);



//router
// app.get('/', (req, res)=>{
// 	res.render('index');
// });

//server startup
app.listen(port, (error)=>{
	console.log('server strated at '+port);
});