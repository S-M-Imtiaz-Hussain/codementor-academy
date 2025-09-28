import React, {useState} from 'react';
import { useAuth } from '../contexts/AuthContext';
import Card from '../components/Card';
import Button from '../components/Button';
import Input from '../components/Input';


function LoginPage() {

    const { login } =useAuth();
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [errors, setErrors] = useState({email: '', password: ''});

    async function handleSubmit(e: React.FormEvent) {
        e.preventDefault();

        await login(email,password);

        // const newErrors = {email: '', password: ''};

        // if(!email) {
        //     newErrors.email = 'email is requried';
        // }
        // if(!password) {
        //     newErrors.password = 'password is required';
        // }
        //  setErrors(newErrors);

        //  if(!newErrors.email && !newErrors.password) {
        //     console.log('login attempt', {email, password});
        //  }
    }

    // return (
    //     <div className = "min-h-screen flex items-center justify-center bg-gray-50 p-4">
    //         <Card title = "Login to Your Account" className="w-full max-w-md">
    //             <form onSubmit={handleSubmit}>
    //                 <Input label="Email Address" type="email" value={email} onChange={(e) => setEmail(e.target.value)} error={errors.email} placeholder="Enter your email" />
    //                 <Input label="password" type="password" value={password} onChange={(e) => setPassword(e.target.value)} error={errors.password} placeholder="Enter Your Password" />
    //                 <Button type="submit" variant="Primary" className="w-full mt-4">Login </Button>
    //                 <Button type="button" variant="secondary" className="w-full mt-2" onClick={()=>console.log('Go to register')} >Create Account</Button>
    //             </form>
    //         </Card>
    //     </div>
    // );

    return (
        <form onSubmit = {handleSubmit}>
            <Input label="Email Address" type="email" value={email} onChange={(e) => setEmail(e.target.value)} error={errors.email} placeholder="Enter your email" />
            <Input label="password" type="password" value={password} onChange={(e) => setPassword(e.target.value)} error={errors.password} placeholder="Enter Your Password" />
            <Button type="submit" variant="Primary" className="w-full mt-4">Login </Button>
            <Button type="button" variant="secondary" className="w-full mt-2" onClick={()=>console.log('Go to register')} >Create Account</Button>
        </form>
    )
}

export default LoginPage;