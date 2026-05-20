function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }

        function toggleChat() {
            // Check if there is a chat widget available, otherwise log to console
            if (typeof window.LiveChatWidget !== "undefined") {
                window.LiveChatWidget.call('maximize');
            } else {
                console.log("Chat toggled");
                // Optional: Scroll to contact section if no chat widget
                const contactSection = document.getElementById('business-contact');
                if(contactSection) contactSection.scrollIntoView({behavior: 'smooth'});
            }
        }