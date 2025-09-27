import React, { useState } from "react";
import Button from "../components/Button";
import Input from "../components/Input";

// const LoginPage: React.FC = () => {
//     const [email, setEmail] = useState('');
//     const [password, setPassword] = useState('');
//   return (
//     <form action="" className="max-w-md mx-auto mt-16 p-6 border rounded shadow">
//         <h2 className="text-xl font-bold mb-4">Login</h2>
//         <Input label="mail" type="email" value={email} onChange={e => setEmail(e.target.value)} />
//         <Input label="Password" type="password" value={password} onChange={e => setPassword(e.target.value)} />
//         <Button className="mt-4 w-full" type="submit">Login</Button>
//     </form>
//   );
// }   
// export default LoginPage;


export default function LoginPage() {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');    

    return (
        <form action="" className="max-w-md mx-auto mt-16 p-6 border rounded shadow">
            <h2 className="text-xl font-bold mb-4">Login</h2>
            <Input label="mail" type="email" value={email} onChange={e => setEmail(e.target.value)} />
            <Input label="Password" type="password" value={password} onChange={e => setPassword(e.target.value)} />
            <Button className="mt-4 w-full" type="submit">Login</Button>
        </form>
    );

    
}