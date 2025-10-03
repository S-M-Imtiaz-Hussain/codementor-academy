import React, {useState} from 'react';
import { useAuth } from '../contexts/AuthContext';
import { useNavigate } from 'react-router-dom';
import Card from '../components/Card';
import Button from '../components/Button';
import Input from '../components/Input';


export default function RegisterPage() {

    const {register, loading } = useAuth();

    const [name, setName] = useState('');
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [errors, setErrors] = useState({name: '', email: '', password: '', general: '',});
    const navigate = useNavigate();

    async function handleSubmit(e: React.FormEvent) {
        e.preventDefault();

        setErrors({ name: '', email: '', password: '', general: ''});

        const newErrors = {name: '', email: '', password: '', general: ''};
        if(!name.trim()) newErrors.name = 'Name is required';
        if(!email.trim()) newErrors.email = 'Email is required';
        if(!password.trim()) newErrors.password = 'Password is required';   
        if(Object.values(newErrors).some(Boolean)) {
            setErrors(newErrors);
            return;
        }


        try{
            await register(name, email, password);
            navigate('/dashboard');
            console.log('Registration Successful', {name, email, password});
        } catch(error: any) {
            setErrors(prev => ({...prev, general: error.message}));
        }
    }

    return (
        <div className="min-h-screen flex items-center justify-center bg-gray-50 p-4">
            <Card title="Create a New Account" className="w-full max-w-md">
                <form onSubmit={handleSubmit}>
                    {errors.general && (
                        <div className="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                            {errors.general}
                        </div>
                    )}

                    <Input 
                        label="FUll Name" type="text" value={name} 
                        onChange={e => setName(e.target.value)}
                        error={errors.name} placeholder="Enter full name"
                    />
                    <Input 
                        label="Email Address" type="email" value={email}
                        onChange={e => setEmail(e.target.value)}
                        error={errors.email} placeholder="you@example.com"
                    />
                    <Input 
                        label="Password" type="password" value={password}
                        onChange={e =>setPassword(e.target.value)}
                        error={errors.password} placeholder="At least 8 Characters"
                    />
                    <Button
                        type="submit"
                        variant="primary"
                        className="w-full mt-4"
                        disabled={loading}
                    >
                        {loading ? 'Creating Account...' : 'Register'}    
                    </Button>

                </form>
            </Card>
        </div>
    );


}