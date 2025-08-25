import React, { useState } from 'react';


function Registration() {
const [name, setName] = useState('');
const [email, setEmail] = useState('');


const handleSubmit = (e) => {
e.preventDefault();
alert(`Registered: ${name}, ${email}`);
};


return (
<div className="container mt-5" style={{maxWidth: 520}}>
<h2>Register</h2>
<form onSubmit={handleSubmit}>
<div className="mb-3">
<label className="form-label">Name</label>
<input type="text" value={name} onChange={(e)=>setName(e.target.value)} className="form-control" required/>
</div>
<div className="mb-3">
<label className="form-label">Email</label>
<input type="email" value={email} onChange={(e)=>setEmail(e.target.value)} className="form-control" required/>
</div>
<button type="submit" className="btn btn-success">Submit</button>
</form>
</div>
);
}


export default Registration;