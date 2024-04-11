import React, { useEffect } from 'react';
import Cookies from 'js-cookie';
function UserHome() {
  useEffect(() => {
    const userSessionCookie = Cookies.get('user_session');
    if (!userSessionCookie) {
      window.location.href = '/login/user';
    }
}, []); // Chỉ chạy một lần khi component được render
  return (
    <div>
      <h1>Trang chính của người dùng</h1>
      <p>Xin chào, người dùng!</p>
    </div>
  );
}

export default UserHome;