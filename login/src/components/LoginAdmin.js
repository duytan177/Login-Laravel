import React, { useState } from 'react';
import axios from 'axios';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import { useNavigate } from 'react-router-dom';
function LoginAdmin({onLogin}) {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [error, setError] = useState('');
    const navigate = useNavigate();
    const sites = "ADMIN";
    const handleSubmit = async (e) => {
      e.preventDefault();
      try {
        const response = await axios.post('http://localhost:80/api/login', { email, password,sites });
        onLogin(sites);
        console.log(response.data); // Xử lý kết quả trả về từ API ở đây
        navigate('/home/admin')
      } catch (error) {
        let code = error.response.status
        if(code === "409"){
            setError(error.response.data.error);
        }else{
          setError(error.response.data.error);
        }
      }
    };
  

  return (
    <div className="container " style={{marginTop: "100px", padding:"200px"}}>
      <div className="row justify-content-center">
        <div className="col-md-12">
          <div className="card">
            <div className="card-body">
            <h2 className="card-title text-center md-4">ADMIN</h2>
              <h3 className="card-title text-center md-4">Đăng nhập</h3>
              {error && <div className="alert alert-danger" role="alert">{error}</div>}
              <form onSubmit={handleSubmit}>
                <div className="mb-3">
                  <label htmlFor="email" className="form-label">Tên người dùng</label>
                  <input type="text" className="form-control" id="email" value={email} onChange={(e) => setEmail(e.target.value)} required />
                </div>
                <div className="mb-3">
                  <label htmlFor="password" className="form-label">Mật khẩu</label>
                  <input type="password" className="form-control" id="password" value={password} onChange={(e) => setPassword(e.target.value)} required />
                </div>
                <div className="text-center">
                  <button type="submit" className="btn btn-primary">Đăng nhập</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export default LoginAdmin;