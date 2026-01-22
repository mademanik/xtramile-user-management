import { useState } from 'react'
import './App.css'

function App() {
    const [name, setName] = useState('')
    const [email, setEmail] = useState('')
    const [userResult, setUserResult] = useState(null)

    const handleSubmit = async (e) => {
        e.preventDefault()
        try {
            const response = await fetch(import.meta.env.VITE_API_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ name, email }),
            });
            const data = await response.json()
            setUserResult(data)
        } catch (err) {
            console.error("Fetch error:", err)
        }
    }

    return (
        <div className="container">
            <h2>User Registration</h2>
            <form onSubmit={handleSubmit}>
                <div className="form-group">
                    <label>Full Name</label>
                    <input type="text" placeholder="e.g. David Jonson" value={name} onChange={e => setName(e.target.value)} required />
                </div>
                <div className="form-group">
                    <label>Email Address</label>
                    <input type="email" placeholder="name@example.com" value={email} onChange={e => setEmail(e.target.value)} required />
                </div>
                <button type="submit">Submit Data</button>
            </form>

            {userResult && (
                <div className="result-card">
                    <h3>User Created Successfully!</h3>
                    <p><strong>ID:</strong> {userResult.id}</p>
                    <p><strong>Name:</strong> {userResult.name}</p>
                    <p><strong>Email:</strong> {userResult.email}</p>
                </div>
            )}
        </div>
    )
}

export default App