-- =====================================================
-- Object:  Table [dbo].[EstadosTickets]
-- Script Date: 19/4/2025 11:40:26
-- =====================================================

CREATE TABLE [dbo].[EstadosTickets] (
    ID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
    Estado VARCHAR(50) NOT NULL UNIQUE
);