<!-- footer.php -->
<footer style="background-color: rgba(0, 128, 0, 0.8); padding: 8px 16px; color: #ffffff; text-align: center; font-size: 12px; position: fixed; bottom: 0; left: 0; right: 0; z-index: 999;">
    <div style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
        <div style="flex: 1; text-align: left; padding: 4px;">
            <p>&copy; 2024 Barangay Information and Management System</p>
        </div>
        <div style="flex: 1; text-align: center; padding: 4px;">
            <p>Developed by <strong>BIMS Group</strong></p>
        </div>
        <div style="flex: 1; text-align: right; padding: 4px;">
            <p>All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- CSS for Media Queries -->
<style>
    @media (max-width: 768px) {
        footer {
            font-size: 10px;
            padding: 6px 12px;
        }
        footer .container {
            flex-direction: column;
            text-align: center;
        }
        footer .container div {
            margin-bottom: 8px;
        }
    }
</style>
