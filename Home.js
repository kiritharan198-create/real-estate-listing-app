import React from 'react';
import { Link } from 'react-router-dom';


function Home() {
return (
<div className="container mt-5">
<h1>Welcome to Real Estate Listing App</h1>
<p>Manage your property data efficiently.</p>
<Link to="/registration" className="btn btn-primary">Register</Link>
</div>
);
}


export default Home;