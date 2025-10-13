import React from 'react';


type ButtonProps = {
  children: React.ReactNode;
  variant?: 'primary' | 'secondary';
} & React.ButtonHTMLAttributes<HTMLButtonElement>;  

function Button({children, variant = 'primary', className='' , ...props} : ButtonProps) {
    const base = "px-4 py-2 rounded font-medium focus:outline-none focus:ring-2 focus:ring-offset-2";

    let variants = "";

    if(variant === 'primary') {
        variants = "bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-400";
    } else if (variant === 'secondary') {
        variants = "bg-gray-200 text-white hover:bg-gray-700 focus:ring-gray-400";  
    }

    const finalStyles = `${base} ${variants} ${className}`;

    return (
        <button className = {finalStyles} {...props}>
            {children}
        </button>
    )
}


export default Button;