local ReplicatedStorage = game:GetService("ReplicatedStorage")
local Players = game:GetService("Players")
local player = Players.LocalPlayer
local playerGui = player:WaitForChild("PlayerGui")

-- Function to create a circle of parts
local function createCircle(centerPosition)
    local radius = 10
    local partsCount = 10
    for i = 1, partsCount do
        local angle = (i / partsCount) * (2 * math.pi)
        local x = centerPosition.X + radius * math.cos(angle)
        local z = centerPosition.Z + radius * math.sin(angle)
        local part = Instance.new("Part")
        part.Shape = Enum.PartType.Ball
        part.Size = Vector3.new(5, 5, 5)
        part.Position = Vector3.new(x, centerPosition.Y, z)
        part.Anchored = true
        part.Parent = workspace
    end
end

-- Function to create a square of parts
local function createSquare(centerPosition)
    local size = 10
    local halfSize = size / 2
    local positions = {
        Vector3.new(centerPosition.X - halfSize, centerPosition.Y, centerPosition.Z - halfSize),
        Vector3.new(centerPosition.X + halfSize, centerPosition.Y, centerPosition.Z - halfSize),
        Vector3.new(centerPosition.X + halfSize, centerPosition.Y, centerPosition.Z + halfSize),
        Vector3.new(centerPosition.X - halfSize, centerPosition.Y, centerPosition.Z + halfSize)
    }
    for _, position in ipairs(positions) do
        local part = Instance.new("Part")
        part.Size = Vector3.new(5, 5, 5)
        part.Position = position
        part.Anchored = true
        part.Parent = workspace
    end
end

-- Function to create a triangle of parts
local function createTriangle(centerPosition)
    local size = 10
    local height = math.sqrt(3) / 2 * size
    local positions = {
        Vector3.new(centerPosition.X, centerPosition.Y, centerPosition.Z + height / 2),
        Vector3.new(centerPosition.X - size / 2, centerPosition.Y, centerPosition.Z - height / 2),
        Vector3.new(centerPosition.X + size / 2, centerPosition.Y, centerPosition.Z - height / 2)
    }
    for _, position in ipairs(positions) do
        local part = Instance.new("Part")
        part.Size = Vector3.new(5, 5, 5)
        part.Position = position
        part.Anchored = true
        part.Parent = workspace
    end
end

-- Function to set up GUI
local function setupGui()
    local screenGui = Instance.new("ScreenGui")
    screenGui.Name = "DraggableSummonGui"
    screenGui.ResetOnSpawn = false
    screenGui.IgnoreGuiInset = true
    screenGui.Parent = playerGui

    local dragFrame = Instance.new("Frame")
    dragFrame.Size = UDim2.new(0, 140, 0, 200)
    dragFrame.Position = UDim2.new(1, -160, 0, 20)
    dragFrame.BackgroundColor3 = Color3.fromRGB(0, 0, 0)
    dragFrame.BackgroundTransparency = 0.6
    dragFrame.ZIndex = 1
    dragFrame.BorderSizePixel = 0
    dragFrame.Parent = screenGui

    local dragTextBox = Instance.new("TextBox")
    dragTextBox.Size = UDim2.new(1, 0, 1, 0)
    dragTextBox.Position = UDim2.new(0, 0, 0, 0)
    dragTextBox.BackgroundTransparency = 1
    dragTextBox.Text = ""
    dragTextBox.TextScaled = true
    dragTextBox.ZIndex = 2
    dragTextBox.ClearTextOnFocus = false
    dragTextBox.TextEditable = false
    dragTextBox.Font = Enum.Font.Gotham
    dragTextBox.BorderSizePixel = 0
    dragTextBox.Parent = dragFrame

    local enemyNameTextBox = Instance.new("TextBox")
    enemyNameTextBox.Size = UDim2.new(0, 92, 0, 30)
    enemyNameTextBox.Position = UDim2.new(0.5, -46, 0, 10)
    enemyNameTextBox.PlaceholderText = "[EX: CWAzurewrath3]"
    enemyNameTextBox.Text = ""
    enemyNameTextBox.TextScaled = true
    enemyNameTextBox.BackgroundColor3 = Color3.fromRGB(0, 0, 0)
    enemyNameTextBox.TextColor3 = Color3.fromRGB(255, 255, 255)
    enemyNameTextBox.ZIndex = 3
    enemyNameTextBox.Font = Enum.Font.Gotham
    enemyNameTextBox.BorderSizePixel = 0
    enemyNameTextBox.Parent = dragFrame

    local summonCountTextBox = Instance.new("TextBox")
    summonCountTextBox.Size = UDim2.new(0, 92, 0, 30)
    summonCountTextBox.Position = UDim2.new(0.5, -46, 0, 50)
    summonCountTextBox.PlaceholderText = "Enter count"
    summonCountTextBox.Text = ""
    summonCountTextBox.TextScaled = true
    summonCountTextBox.BackgroundColor3 = Color3.fromRGB(0, 0, 0)
    summonCountTextBox.TextColor3 = Color3.fromRGB(255, 255, 255)
    summonCountTextBox.ZIndex = 3
    summonCountTextBox.Font = Enum.Font.Gotham
    summonCountTextBox.BorderSizePixel = 0
    summonCountTextBox.Parent = dragFrame

    local summonButton = Instance.new("TextButton")
    summonButton.Size = UDim2.new(0, 85, 0, 20)
    summonButton.Position = UDim2.new(0.5, -42.5, 0, 90)
    summonButton.Text = "[SUMMON]"
    summonButton.TextScaled = true
    summonButton.BackgroundColor3 = Color3.fromRGB(0, 0, 0)
    summonButton.TextColor3 = Color3.fromRGB(255, 255, 255)
    summonButton.ZIndex = 3
    summonButton.Font = Enum.Font.Gotham
    summonButton.BorderSizePixel = 0
    summonButton.Parent = dragFrame

    local killAllButton = Instance.new("TextButton")
    killAllButton.Size = UDim2.new(0, 85, 0, 20)
    killAllButton.Position = UDim2.new(0.5, -42.5, 0, 120)
    killAllButton.Text = "[KILL ALL]"
    killAllButton.TextScaled = true
    killAllButton.BackgroundColor3 = Color3.fromRGB(255, 0, 0)
    killAllButton.TextColor3 = Color3.fromRGB(255, 255, 255)
    killAllButton.ZIndex = 3
    killAllButton.Font = Enum.Font.Gotham
    killAllButton.BorderSizePixel = 0
    killAllButton.Parent = dragFrame

    local function createShapeButton(name, positionY, color, onClick)
        local button = Instance.new("TextButton")
        button.Size = UDim2.new(0, 85, 0, 20)
        button.Position = UDim2.new(0.5, -42.5, 0, positionY)
        button.Text = name
        button.TextScaled = true
        button.BackgroundColor3 = color
        button.TextColor3 = Color3.fromRGB(255, 255, 255)
        button.ZIndex = 3
        button.Font = Enum.Font.Gotham
        button.BorderSizePixel = 0
        button.Parent = dragFrame
        button.MouseButton1Click:Connect(onClick)
        return button
    end

    local circleButton = createShapeButton("[CIRCLE]", 150, Color3.fromRGB(0, 255, 0), function()
        createCircle(Vector3.new(0, 10, 0))
    end)

    local squareButton = createShapeButton("[SQUARE]", 180, Color3.fromRGB(0, 0, 255), function()
        createSquare(Vector3.new(10, 10, 0))
    end)

    local triangleButton = createShapeButton("[TRIANGLE]", 210, Color3.fromRGB(255, 255, 0), function()
        createTriangle(Vector3.new(-10, 10, 0))
    end)

    summonButton.MouseButton1Click:Connect(function()
        local humanoidRootPart = player.Character and player.Character:FindFirstChild("HumanoidRootPart")
        if humanoidRootPart then
            local summonCount = tonumber(summonCountTextBox.Text) or 10
            local enemyName = enemyNameTextBox.Text
            for i = 1, summonCount do
                local args = {
                    enemyName,
                    humanoidRootPart.CFrame
                }
                ReplicatedStorage.Remotes.SummonEnemy:FireServer(unpack(args))
            end
        else
            warn("HumanoidRootPart not found.")
        end
    end)

    killAllButton.MouseButton1Click:Connect(function()
        local passwords = "{DEkfa2l31kaM-134si3-122z-"
        local passworde = "-aaaZd13kaM-00992}"

        local function info()
            if player:FindFirstChild("remotesFired") then
                player.remotesFired.Value = player.remotesFired.Value + 1
                remotesfired = player.remotesFired.Value
            else
                local remotesfireda = Instance.new("IntValue", player)
                remotesfireda.Name = "remotesFired"
                remotesfireda.Value = 1
                remotesfired = remotesfireda.Value
            end
            local number = math.ceil((remotesfired * 7 + 15) ^ 2.51 + 125.33)
            local newpass = passwords .. number .. passworde
            return newpass
        end

        for _, v in pairs(game.Workspace:GetDescendants()) do
            if v ~= player.Character and v:FindFirstChild("Humanoid") then
                task.spawn(game.ReplicatedStorage.Remotes.Damage.InvokeServer, game.ReplicatedStorage.Remotes.Damage, v, 9e18, info(), workspace.Time.Value)
            end
        end
    end)

    -- Draggable functionality
    local dragging = false
    local dragStart, startPos

    local function updateDrag(input)
        local delta = input.Position - dragStart
        local newX = startPos.X.Scale + delta.X / screenGui.AbsoluteSize.X
        local newY = startPos.Y.Scale + delta.Y / screenGui.AbsoluteSize.Y
        dragFrame.Position = UDim2.new(0, newX, 0, newY)
    end

    local function onInputBegan(input)
        if input.UserInputType == Enum.UserInputType.MouseButton1 or input.UserInputType == Enum.UserInputType.Touch then
            dragging = true
            dragStart = input.Position
            startPos = dragFrame.Position
            input.Changed:Connect(function()
                if input.UserInputState == Enum.UserInputState.End then
                    dragging = false
                end
            end)
        end
    end

    local function onInputChanged(input)
        if input.UserInputType == Enum.UserInputType.MouseMovement or input.UserInputType == Enum.UserInputType.Touch then
            if dragging then
                updateDrag(input)
            end
        end
    end

    dragTextBox.InputBegan:Connect(onInputBegan)
    dragTextBox.InputChanged:Connect(onInputChanged)
end

setupGui()

player.CharacterAdded:Connect(function()
    local newCharacter = player.Character or player.CharacterAdded:Wait()
    newCharacter:WaitForChild("HumanoidRootPart")
    setupGui()
end)
