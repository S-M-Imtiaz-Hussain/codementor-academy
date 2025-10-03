import React from 'react';
import { useAuth } from '../contexts/AuthContext.tsx';
import Card from '../components/Card.tsx';
import Button from '../components/Button.tsx';
import Input from '../components/Input.tsx';


function ProfilePage() {
    const { user } = useAuth();

    return (
        <div className="min-h-screen bg-gray-50 p-4">
            <div className="max-w-2xl mx-auto">
                <Card title="My Profile" className="mb-6">
                    <form>
                        <Input label="Full Name" value={user?.name || ''} readOnly />
                        <Input label="Email Address" type="email" value={user?.email || ''} readOnly />
                        <div className="text-sm text-gray-500 mb-4">
                            Profile Editing will be available soon.
                        </div>
                        <Button variant="secondary" disabled>
                            Save Changes (Coming soon)
                        </Button>
                    </form>
                </Card>
            </div>
        </div>
    );
}

export default ProfilePage