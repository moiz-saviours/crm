import Header from "../Components/Header.jsx";
import React from 'react'

const MainLayout = ({ children }) => {
    return (
            <>
                <Header/>
                <main>
                    {children}
                </main>
            </>

    )
}
export default MainLayout
