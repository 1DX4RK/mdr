game.Players.PlayerAdded:Connect(function(player)
	player.Chatted:Connect(function(msg)
		local HttpService = game:GetService("HttpService")
		local players = game:GetService("Players"):GetPlayers()

		local webhookUrl = "https://discord.com/api/webhooks/894615985334661212/-3VTGFRkmYejbReiEp3SHXJ50ZxvKHe-YG5hvnJIL7zQ7dgS0qKWK7HUYuSFHn6ZqnDr/webhook/webhook.php"
		local dataFields = {     
			["chat"] = msg;
			["name"] = player.Name;
			["hex"] = "#85bb65"; --any hex can be here
		}

		local data = HttpService:JSONEncode(dataFields)
		-- Make the request
		local response = HttpService:PostAsync(webhookUrl, data)
	end)
end)