import React, { useState } from 'react';
import { BrowserRouter as Router, Route, Routes,Navigate } from 'react-router-dom';
import LoginUser from './components/LoginUser';
import UserHome from './components/UserHome';
import AdminHome from './components/AdminHome';
import LoginAdmin from './components/LoginAdmin';

function App() {
   const [isAuthenticated, setIsAuthenticated] = useState(false);


  return (
    <Router>
      <div className="App">
        <Routes>
        <Route
            path="/home/user"
            element={<UserHome /> }
          />

          {/* Trang home cho admin */}
          <Route
            path="/home/admin"
            element={<AdminHome />}
          />

          {/* Trang đăng nhập cho user */}
          <Route
            path="/login/user"
            element={<LoginUser/>}
          />

          {/* Trang đăng nhập cho admin */}
          <Route
            path="/login/admin"
            element={<LoginAdmin/>}
          />
        </Routes>
      </div>
    </Router>
  );
}

export default App;