import React from 'react';

type InputProps = React.InputHTMLAttributes<HTMLInputElement> & {
  label?: string;
  error?: string;
};

function Input({ label, error, className='', ...props }: InputProps) {

    const baseStyles = "w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500";
    const errorStyles= error ? 'border-red-500' : '';
    const finalStyles = '${baseStyles} ${errorStyeles} ${className}';

    return (
        <div className="mb-4">
            {label && <label className="block mb-1 font-medium text-sm">{label}</label>}
            <input className = {finalStyles} {...props} />
            {error && (<p className="text-red-500 text-xs mt-1">{error}</p>)}
        </div>
    );
}

export default Input;