-- =====================================================
-- Object:  Table [dbo].[estados_clientes]
-- Script Date: 19/4/2025 11:40:26
-- =====================================================

CREATE TABLE [dbo].[estados_clientes] (
    [id] [int] IDENTITY(1,1) NOT NULL,
	[nombre_estado] [varchar](50) NOT NULL,

    CONSTRAINT UQ_nombre_estado UNIQUE NONCLUSTERED (nombre_estado)
);