import Header from "../Components/Header.jsx";
import React from 'react'

const MainLayout = ({children}) => {
    return (
        <div className="task-layout">
            <Header/>
            <main>
                {children}
            </main>
        </div>
    )
}
export default MainLayout
