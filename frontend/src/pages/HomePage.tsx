import React from "react";
import Button from "../components/Button";

const HomePage: React.FC = () => (
    <div className="p-6">
        <h1 className="text-2xl font-bold mb-4">Welcome to the Home Page!</h1>
        <Button variant="primary" onClick={() => alert('Clicked!')}>Primary Button</Button>
        <Button variant="secondary" className="ml-4">Secondary Button</Button>
    </div>
)

export default HomePage;