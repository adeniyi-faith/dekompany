function toggleStudentMenu() {
            const menu = document.getElementById('student-mobile-menu');
            menu.classList.toggle('hidden');
        }

        function toggleChat() {
            if (typeof window.LiveChatWidget !== "undefined") {
                window.LiveChatWidget.call('maximize');
            } else {
                console.log("Chat toggled");
                // Fallback if chat widget isn't loaded yet or scroll to contact
                const contactSection = document.getElementById('student-contact');
                if(contactSection) contactSection.scrollIntoView({behavior: 'smooth'});
            }
        }