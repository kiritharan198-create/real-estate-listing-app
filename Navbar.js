import React from 'react';
import { NavLink } from 'react-router-dom';


function Navbar() {
return (
<nav className="navbar navbar-expand-lg navbar-dark bg-dark">
<div className="container">
<NavLink className="navbar-brand" to="/">RealEstate</NavLink>
<button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false">
<span className="navbar-toggler-icon"></span>
</button>
<div id="nav" className="collapse navbar-collapse">
<ul className="navbar-nav ms-auto">
<li className="nav-item"><NavLink className="nav-link" to="/">Home</NavLink></li>
<li className="nav-item"><NavLink className="nav-link" to="/registration">Registration</NavLink></li>
<li className="nav-item"><NavLink className="nav-link" to="/about">About</NavLink></li>
</ul>
</div>
</div>
</nav>
);
}


export default Navbar;