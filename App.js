import React, { useState } from 'react';
import { Home as HomeIcon, UserPlus, Info } from 'lucide-react';
import { useEffect } from 'react'; // Added useEffect for potential future use or state management related to data fetching.

/**
 * Navbar component for navigation.
 * Uses a simple state-based routing system.
 * @param {object} props - Component props.
 * @param {string} props.currentPage - The currently active page.
 * @param {function} props.setCurrentPage - Function to set the current page.
 */
const Navbar = ({ currentPage, setCurrentPage }) => {
  const navItems = [
    { name: 'Home', icon: HomeIcon, page: 'home' },
    { name: 'Register', icon: UserPlus, page: 'registration' },
    { name: 'About', icon: Info, page: 'about' },
  ];

  return (
    <nav className="bg-white shadow-lg sticky top-0 z-50">
      <div className="container mx-auto px-4 py-3 flex justify-between items-center">
        <a href="#" onClick={(e) => { e.preventDefault(); setCurrentPage('home'); }} className="text-2xl font-bold text-gray-800 flex items-center gap-2">
          <span className="text-blue-600">Real</span>Estate
        </a>
        <div className="hidden md:flex items-center space-x-4">
          {navItems.map((item) => {
            const isActive = currentPage === item.page;
            return (
              <a
                key={item.page}
                href="#"
                onClick={(e) => { e.preventDefault(); setCurrentPage(item.page); }}
                className={`flex items-center gap-1.5 px-3 py-2 rounded-lg transition-colors duration-200
                  ${isActive ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900'}`
                }
              >
                <item.icon className="w-5 h-5" />
                <span>{item.name}</span>
              </a>
            );
          })}
        </div>
        <div className="md:hidden">
          <button className="text-gray-600 hover:text-gray-900 focus:outline-none">
            {/* Hamburger icon for mobile menu - not functional in this demo */}
            <svg className="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
          </button>
        </div>
      </div>
    </nav>
  );
};

/**
 * Home Page component.
 * Displays a hero section and some example listings.
 */
const HomePage = () => {
  const listings = [
    { id: 1, title: 'Luxury Villa with Pool', location: 'Colombo', details: '4 Beds • 3 Baths', price: 'LKR 85,000,000', image: 'https://placehold.co/600x400/1e40af/ffffff?text=Luxury+Villa' },
    { id: 2, title: 'Modern Apartment', location: 'Kandy', details: '2 Beds • 2 Baths', price: 'LKR 32,500,000', image: 'https://placehold.co/600x400/3b82f6/ffffff?text=Modern+Apartment' },
    { id: 3, title: 'Prime Land', location: 'Galle', details: '10 Perch Land', price: 'LKR 5,900,000', image: 'https://placehold.co/600x400/60a5fa/ffffff?text=Prime+Land' },
  ];

  return (
    <>
      {/* Hero Section with improved positioning */}
      <div className="relative bg-blue-900 text-white rounded-2xl shadow-xl p-8 mb-8 flex items-center justify-center min-h-[300px] overflow-hidden">
        <div className="absolute inset-0 z-0" style={{ backgroundImage: `url(https://picsum.photos/seed/realestate-hero/1600/600)`, backgroundSize: 'cover', backgroundPosition: 'center', filter: 'brightness(0.6)' }}></div>
        <div className="relative z-10 text-center p-6 bg-black bg-opacity-40 rounded-xl">
          <h1 className="text-4xl md:text-5xl font-extrabold mb-4">Find Your Dream Property</h1>
          <p className="text-lg md:text-xl font-light mb-6">Explore the best properties for sale and rent in Sri Lanka.</p>
        </div>
      </div>

      {/* Listings Section */}
      <section className="py-8">
        <h2 className="text-3xl font-bold text-gray-800 mb-6 text-center">Featured Listings</h2>
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          {listings.map(listing => (
            <div key={listing.id} className="bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300 ease-in-out">
              <img src={listing.image} alt={listing.title} className="w-full h-48 object-cover" />
              <div className="p-5 flex flex-col justify-between h-full">
                <div>
                  <h3 className="text-xl font-semibold text-gray-800">{listing.title}</h3>
                  <p className="text-gray-500 text-sm mt-1">{listing.location}</p>
                  <p className="text-gray-600 mt-2">{listing.details}</p>
                </div>
                <p className="text-blue-600 font-bold text-lg mt-3">{listing.price}</p>
              </div>
            </div>
          ))}
        </div>
      </section>
    </>
  );
};

/**
 * Registration Page component.
 * Placeholder for a registration form.
 */
const RegistrationPage = () => {
  return (
    <div className="bg-white rounded-xl shadow-lg p-6 max-w-lg mx-auto">
      <h2 className="text-2xl font-bold text-center mb-6 text-gray-800">Create an Account</h2>
      <form>
        <div className="mb-4">
          <label htmlFor="name" className="block text-gray-700 font-medium mb-2">Name</label>
          <input type="text" id="name" className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter your full name" />
        </div>
        <div className="mb-4">
          <label htmlFor="email" className="block text-gray-700 font-medium mb-2">Email</label>
          <input type="email" id="email" className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter your email" />
        </div>
        <div className="mb-6">
          <label htmlFor="password" className="block text-gray-700 font-medium mb-2">Password</label>
          <input type="password" id="password" className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter your password" />
        </div>
        <button type="submit" className="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition-colors duration-200">
          Register
        </button>
      </form>
    </div>
  );
};

/**
 * About Page component.
 * Provides information about the project.
 */
const AboutPage = () => {
  return (
    <div className="bg-white rounded-xl shadow-lg p-6 max-w-2xl mx-auto">
      <h2 className="text-2xl font-bold text-center mb-4 text-gray-800">About This Project</h2>
      <p className="text-gray-600 mb-4">
        This is a simple real estate listing app built with React. The project aims to demonstrate
        the fundamentals of building a dynamic web application, including component-based architecture,
        state management, and routing.
      </p>
      <ul className="list-disc list-inside space-y-2 text-gray-600">
        <li><strong>Built with:</strong> React and Tailwind CSS</li>
        <li><strong>Functionality:</strong> Navigate between a home page, a registration form, and an about page.</li>
        <li><strong>Next Steps:</strong> This can be expanded to include property details, user authentication, and a backend for data persistence.</li>
      </ul>
    </div>
  );
};

/**
 * The main App component that renders the entire application.
 */
const App = () => {
  // State to manage the current page.
  const [currentPage, setCurrentPage] = useState('home');

  // Function to render the correct component based on the current page state.
  const renderPage = () => {
    switch (currentPage) {
      case 'home':
        return <HomePage />;
      case 'registration':
        return <RegistrationPage />;
      case 'about':
        return <AboutPage />;
      default:
        return <HomePage />;
    }
  };

  return (
    <div className="min-h-screen bg-gray-100 font-sans">
      <Navbar currentPage={currentPage} setCurrentPage={setCurrentPage} />
      <main className="container mx-auto px-4 md:px-8 py-8">
        {renderPage()}
      </main>
      <footer className="w-full bg-gray-800 text-white text-center py-4 mt-8">
        Developed by Sarva Kiritharan | 2025
      </footer>
    </div>
  );
};

export default App;